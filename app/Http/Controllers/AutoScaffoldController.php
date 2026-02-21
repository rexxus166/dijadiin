<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\GeminiService;

class AutoScaffoldController extends Controller
{
    public function stream(Request $request)
    {
        $payloadRaw = $request->query('payload');
        if (!$payloadRaw) {
            return response()->json(['error' => 'No payload provided'], 400);
        }

        $data = json_decode($payloadRaw, true);
        $projectName = $data['project'] ?? null;
        $concept = $data['concept'] ?? '';
        $features = $data['features'] ?? '';

        if (!$projectName) {
            return response()->json(['error' => 'No active project found'], 400);
        }

        $userId      = Auth::id();
        $basePath    = storage_path('app/generated_projects/' . $userId);
        $projectPath = realpath($basePath . DIRECTORY_SEPARATOR . $projectName);

        if (!$projectPath || !str_starts_with($projectPath, realpath($basePath))) {
            return response()->json(['error' => 'Invalid project path'], 403);
        }

        $response = new StreamedResponse(function () use ($projectName, $projectPath, $concept, $features, $userId) {
            set_time_limit(0);
            while (ob_get_level() > 0) {
                ob_end_flush();
            }

            $sendStatus = function ($message, $type = 'info') {
                $dataOut = json_encode(['type' => $type, 'message' => $message]);
                echo "data: {$dataOut}\n\n";
                flush();
            };

            $sendStatus("Menghubungi AI Architect untuk {$concept}...", 'info');

            // --- STEP 1: Generate JSON Plan ---
            $systemPromptPlan = <<<PROMPT
You are an expert Senior Laravel Architect. You MUST output ONLY valid JSON format, with NO markdown formatting (do not wrap in ```json).
The user wants to add features to an existing fresh Laravel 10 project.
Create a JSON plan that details the files needed to build the features requested.
Schema:
{
  "files": [
    { "type": "migration", "path": "database/migrations/2026_01_01_000000_create_example_table.php" },
    { "type": "model", "path": "app/Models/Example.php" },
    { "type": "controller", "path": "app/Http/Controllers/ExampleController.php" },
    { "type": "view", "path": "resources/views/example/index.blade.php" },
    { "type": "routes", "path": "routes/web.php", "append": true }
  ]
}
Design the database schema properly and make sure the controllers use standard CRUD.
PROMPT;

            $userPromptPlan = "Concept: {$concept}\nFeatures: {$features}\nGenerate the JSON plan based on these requirements.";

            $planJson = GeminiService::callRaw($userId, $systemPromptPlan, $userPromptPlan, 120);
            if (!$planJson) {
                $sendStatus("Gagal mendapatkan respon (Plan) dari AI.", 'error');
                return;
            }

            $planData = json_decode($planJson, true);
            if (json_last_error() !== JSON_ERROR_NONE || !isset($planData['files'])) {
                $sendStatus("Format JSON plan dari AI tidak valid. " . json_last_error_msg(), 'error');
                return;
            }

            $filesGen = $planData['files'];
            $totalFiles = count($filesGen);
            $sendStatus("AI Architect merencanakan pembuatan {$totalFiles} file.", 'success');

            // --- STEP 2: Generate Each File ---
            $systemPromptFile = <<<PROMPT
You are an expert Senior Laravel Architect. You MUST output ONLY raw code for the requested file. Do NOT include markdown fences like ```php or explanations.
Requirements for generated code:
1. Best practice Laravel 10.
2. For Blades, use Tailwind CSS via CDN (<script src="https://cdn.tailwindcss.com"></script>) and make it look clean and production-ready.
3. Database relationships should be clear in Models and Migrations.
4. Controllers should have fully functional CRUD pulling data from database.
5. Provide ONLY the code.
PROMPT;

            $fileContextStr = "Here is the overall architecture plan to keep context consistent:\n" . json_encode($planData, JSON_PRETTY_PRINT);

            foreach ($filesGen as $index => $fileObj) {
                $filePath = ltrim(str_replace(['../', '..\\'], '', $fileObj['path']), '/\\');
                $isAppend = !empty($fileObj['append']);

                $sendStatus(sprintf("[%d/%d] Generating %s...", $index + 1, $totalFiles, $filePath), 'info');

                $userPromptFile = "{$fileContextStr}\n\nPlease generate ONLY the raw code content for this file:\nPath: {$filePath}\nType: {$fileObj['type']}";

                $code = GeminiService::callRaw($userId, $systemPromptFile, $userPromptFile, 120);
                if (!$code) {
                    $sendStatus("Gagal generate kode untuk {$filePath}.", 'error');
                    continue;
                }

                $absPath = $projectPath . DIRECTORY_SEPARATOR . $filePath;
                $dir = dirname($absPath);

                if (!is_dir($dir)) {
                    if (!mkdir($dir, 0755, true)) {
                        $sendStatus("Gagal membuat direktori untuk {$filePath}", 'error');
                        continue;
                    }
                }

                if ($isAppend && file_exists($absPath)) {
                    $existingCont = file_get_contents($absPath);
                    // Specifically for web.php, let's append nicely
                    $appendContent = "\n// --- AI Generated Routes for {$concept} ---\n" . $code . "\n";
                    file_put_contents($absPath, $existingCont . $appendContent);
                    $sendStatus("Berhasil modifikasi {$filePath}", 'success');
                } else {
                    file_put_contents($absPath, $code);
                    $sendStatus("Berhasil membuat {$filePath}", 'success');
                }
            }

            $sendStatus("done", 'done');
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }
}
