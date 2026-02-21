<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\GeminiService;

class GeminiChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'prompt'       => 'required|string',
            'file_content' => 'nullable|string',
            'project'      => 'required|string',
        ]);

        $prompt      = $request->input('prompt');
        $fileContent = $request->input('file_content', '');
        $project     = $request->input('project');

        $basePath    = storage_path('app/generated_projects/' . Auth::id());
        $projectPath = realpath($basePath . DIRECTORY_SEPARATOR . $project);

        if (!$projectPath || !str_starts_with($projectPath, realpath($basePath))) {
            return response()->json(['error' => 'Invalid project path.'], 403);
        }

        // Fetch original AI blueprint for context
        $genProjectInfo  = \App\Models\GeneratedProject::where('name', $project)->first();
        $originalContext = $genProjectInfo ? $genProjectInfo->ai_prompt : '';
        $contextString   = $originalContext ? "Master Project Blueprint/Context from User: {$originalContext}\n" : '';

        $systemInstruction = <<<PROMPT
You are an expert Senior Laravel Architect AI. The user will provide a prompt and optionally their currently opened file. 
You are fully capable of modifying the current file or creating/modifying multiple files (like CRUD, Auth, Controllers, Models, etc.) across the project.
You MUST respond IN STRICT JSON FORMAT ONLY. Do not use markdown blocks like ```json.
{$contextString}
The JSON must follow this precise schema:
{
  "message": "A friendly short message describing what you did.",
  "files": [
    {
      "path": "app/Http/Controllers/ExampleController.php",
      "content": "<?php\\n\\nnamespace App\\\\Http\\\\Controllers;\\n..."
    }
  ]
}
If the user's request pertains to the opened file, ensure 'path' is the same relative path.
For multiple files, provide each in the 'files' array. Remember this is a fresh Laravel 10 project using Tailwind.
PROMPT;

        $userPrompt = "CURRENT OPENED FILE:\n{$fileContent}\n\nUSER REQUEST: {$prompt}";

        // --- Call Gemini with automatic failover ---
        $result = GeminiService::call(Auth::id(), $systemInstruction, $userPrompt, 60);

        if (!$result['success']) {
            return response()->json(['error' => $result['error']], 500);
        }

        $rawText  = $result['text'];
        $keyUsed  = $result['key_used'];

        // Extract JSON block (robust against conversational noise)
        $jsonStart = strpos($rawText, '{');
        $jsonEnd   = strrpos($rawText, '}');

        if ($jsonStart !== false && $jsonEnd !== false && $jsonEnd >= $jsonStart) {
            $possibleJson = substr($rawText, $jsonStart, $jsonEnd - $jsonStart + 1);
            $jsonResponse = json_decode($possibleJson, true);
        } else {
            $jsonResponse = json_decode($rawText, true);
        }

        if (json_last_error() !== JSON_ERROR_NONE || !isset($jsonResponse['files'])) {
            Log::error("Gemini JSON Parse Error [{$keyUsed}]. Raw: " . $rawText);
            return response()->json([
                'error'     => 'The AI returned an invalid response format. Please try again.',
                'debug_raw' => $rawText,
            ], 500);
        }

        // Write all files immediately to disk
        foreach ($jsonResponse['files'] as $fileObj) {
            $filePath = ltrim(str_replace(['../', '..\\'], '', $fileObj['path']), '/\\');
            $absPath  = $projectPath . DIRECTORY_SEPARATOR . $filePath;
            $dir      = dirname($absPath);

            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            file_put_contents($absPath, $fileObj['content']);
        }

        return response()->json([
            'success' => true,
            'message' => $jsonResponse['message'] ?? 'Actions executed successfully.',
            'files'   => $jsonResponse['files'],
        ]);
    }
}
