<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\ScaffoldProjectService;
use App\Services\EnvGeneratorService;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $basePath = storage_path('app/generated_projects');

        // Prepare SSE Response
        $response = new StreamedResponse(function () use ($projectName, $basePath, $data, $scaffoldService, $envService) {

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

                    // Also log to storage/logs/laravel.log so we can trace it in real-time
                    Log::channel('single')->info("Composer Chunk: " . trim($buffer));
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
                \App\Models\GeneratedProject::updateOrCreate(
                    ['name' => $projectName],
                    [
                        'description' => $data['description'] ?? null,
                        'db_type' => $data['db_type'] ?? 'mysql',
                        'db_name' => $data['db_name'] ?? null,
                        'db_port' => $data['db_port'] ?? null,
                        'db_username' => $data['db_username'] ?? null,
                        'ai_prompt' => $data['ai_prompt'] ?? null,
                        'path' => $status['path'],
                    ]
                );

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
