<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\ScaffoldProjectService;
use App\Services\EnvGeneratorService;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\UserApiKey;
use App\Services\GeminiService;

class ProjectStreamController extends Controller
{
    public function stream(Request $request, ScaffoldProjectService $scaffoldService, EnvGeneratorService $envService)
    {
        // 1. Validate data from session or query since SSE is GET
        // But for simplicity, we pass data via query string for GET SSE.
        // It's recommended to encode the payload as JSON query param or individual params.

        $payloadRaw = $request->query('payload');
        if (!$payloadRaw) {
            return response()->json(['error' => 'No payload provided'], 400);
        }

        $data = json_decode($payloadRaw, true);
        $projectName = $data['project_name'] ?? 'ai-project';
        $userId   = Auth::id();
        $basePath = storage_path('app/generated_projects/' . $userId);

        // Prepare SSE Response
        $response = new StreamedResponse(function () use ($projectName, $basePath, $data, $scaffoldService, $envService, $userId) {

            // Remove PHP execution time limit for long-running composer installs
            set_time_limit(0);

            // Disable Output Buffering
            while (ob_get_level() > 0) {
                ob_end_flush();
            }

            $sendStatus = function ($message, $type = 'info') {
                $dataOut = json_encode(['type' => $type, 'message' => $message]);
                echo "data: {$dataOut}\n\n";
                flush();
            };

            $sendStatus("Starting generation for project '{$projectName}'...");

            try {
                $status = $scaffoldService->generateWithStream($projectName, $basePath, function ($type, $buffer) use ($sendStatus) {
                    // Send stdout/stderr from composer immediately to frontend
                    $sendStatus($buffer, 'log');
                });

                if (!$status['success']) {
                    $sendStatus("Scaffolding failed: " . $status['message'], 'error');
                    Log::error("Scaffold Failed: ", $status);
                    return;
                }

                $sendStatus("Scaffolding Complete. Configuring .env settings...", 'info');
                $envService->configureDatabaseEnv($status['path'], $data);
                $sendStatus("Environment Configured!", 'info');

                // Save to database
                $sendStatus("Saving project metadata to database...", 'info');
                $aiPrompt = $data['ai_prompt'] ?? '';
                \App\Models\GeneratedProject::updateOrCreate(
                    ['name' => $projectName],
                    [
                        'user_id'     => Auth::id(),
                        'description' => $data['description'] ?? null,
                        'db_type'     => $data['db_type'] ?? 'mysql',
                        'db_name'     => $data['db_name'] ?? null,
                        'db_port'     => $data['db_port'] ?? null,
                        'db_username' => $data['db_username'] ?? null,
                        'ai_prompt'   => $aiPrompt,
                        'path'        => $status['path'],
                    ]
                );

                // --- AI BUILDER AUTO SCAFFOLD PIPELINE ---
                if (!empty($aiPrompt)) {
                    $apiKey = UserApiKey::resolveForUser($userId);
                    if (!empty($apiKey)) {
                        $sendStatus("Memulai AI Architect Pipeline berdasarkan instruksi Anda...", 'info');
                        $projectPath = $status['path'];

                        // STEP 1: Plan
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

                        $userPromptPlan = "Concept/Features: {$aiPrompt}\nGenerate the JSON plan based on these requirements.";
                        
                        $planJson = GeminiService::callRaw($userId, $systemPromptPlan, $userPromptPlan, 120);
                        if ($planJson) {
                            $planData = json_decode($planJson, true);
                            if (json_last_error() === JSON_ERROR_NONE && isset($planData['files'])) {
                                $filesGen = $planData['files'];
                                $totalFiles = count($filesGen);
                                $sendStatus("AI Architect merencanakan pembuatan {$totalFiles} file...", 'info');

                                // STEP 2: Generate Each File
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

                                    $sendStatus(sprintf("AI Architect: (%d/%d) Menulis %s", $index + 1, $totalFiles, $filePath), 'info');

                                    $userPromptFile = "{$fileContextStr}\n\nPlease generate ONLY the raw code content for this file:\nPath: {$filePath}\nType: {$fileObj['type']}";
                                    
                                    $code = GeminiService::callRaw($userId, $systemPromptFile, $userPromptFile, 120);
                                    if ($code) {
                                        $absPath = rtrim($projectPath, '/\\') . DIRECTORY_SEPARATOR . $filePath;
                                        $dir = dirname($absPath);

                                        if (!is_dir($dir)) {
                                            @mkdir($dir, 0755, true);
                                        }

                                        if ($isAppend && file_exists($absPath)) {
                                            $existingCont = file_get_contents($absPath);
                                            $appendContent = "\n// --- AI Generated Routes ---\n" . $code . "\n";
                                            file_put_contents($absPath, $existingCont . $appendContent);
                                            $sendStatus("Modified: {$filePath}", 'log');
                                        } else {
                                            file_put_contents($absPath, $code);
                                            $sendStatus("Created: {$filePath}", 'log');
                                        }
                                    } else {
                                        $sendStatus("Gagal merelasikan kode untuk {$filePath}.", 'error');
                                    }
                                }
                                $sendStatus("Semua file khusus berhasil dibangun oleh AI!", 'info');
                            } else {
                                $sendStatus("Konsep terlalu kompleks atau format JSON balasan rusak.", 'error');
                            }
                        } else {
                            $sendStatus("Gagal mendapatkan respon blueprint Blueprint dari AI.", 'error');
                        }
                    } else {
                        $sendStatus("API Key Gemini tidak ditemukan. Melewati langkah Auto Scaffold AI.", 'info');
                    }
                }

                // Signal the frontend to redirect
                $sendStatus($projectName, 'done');
            } catch (\Exception $e) {
                $sendStatus("Unexpected Error: " . $e->getMessage(), 'error');
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }
}
