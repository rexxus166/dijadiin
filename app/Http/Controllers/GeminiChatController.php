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
You MUST respond using EXACTLY this XML-like format. Do NOT use JSON or markdown code blocks:
{$contextString}
<file path="app/Http/Controllers/ExampleController.php">
<?php

namespace App\Http\Controllers;
...
</file>

If the user's request pertains to the opened file, ensure 'path' is the same relative path.
For multiple files, provide each in a separate <file> tag. Remember this is a fresh Laravel 10 project using Tailwind.
PROMPT;

        $userPrompt = "CURRENT OPENED FILE:\n{$fileContent}\n\nUSER REQUEST: {$prompt}";

        // --- Call Gemini with automatic failover ---
        $result = GeminiService::call(Auth::id(), $systemInstruction, $userPrompt, 60);

        if (!$result['success']) {
            return response()->json(['error' => $result['error']], 500);
        }

        $rawText  = $result['text'];
        $keyUsed  = $result['key_used'];

        // Parse XML-like format (robust against code escaping issues)
        $files = [];
        // Use non-greedy match for file content, handle possible whitespace around tags
        if (preg_match_all('/<file\s+path="([^"]+)">\s*(.*?)\s*<\/file>/is', $rawText, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $files[] = [
                    'path'    => trim($match[1]),
                    'content' => trim($match[2]),
                ];
            }
        }

        if (empty($files)) {
            Log::error("Gemini Parse Error [{$keyUsed}]. Raw: " . $rawText);
            return response()->json([
                'error'     => 'The AI returned an invalid response format or no files were generated. Please try again.',
                'debug_raw' => $rawText,
            ], 500);
        }

        // Write all files immediately to disk
        foreach ($files as $fileObj) {
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
            'message' => 'Actions executed successfully.',
            'files'   => $files,
        ]);
    }
}
