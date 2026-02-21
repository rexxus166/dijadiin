<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
            'file_content' => 'required|string',
        ]);

        $apiKey = env('GEMINI_API_KEY');

        if (empty($apiKey)) {
            return response()->json(['error' => 'GEMINI_API_KEY is not configured in the host environment.'], 500);
        }

        $prompt = $request->input('prompt');
        $fileContent = $request->input('file_content');

        $systemInstruction = "You are an expert AI software engineer. The user will provide their current file content and a request to modify it. You must return ONLY the raw modified code for the entire file. Do not wrap it in markdown codeblocks (like ```php). Do not add any conversational text. Return exactly the string that should replace the file content.";

        $fullPrompt = "{$systemInstruction}\n\nCURRENT FILE CONTENT:\n{$fileContent}\n\nUSER REQUEST: {$prompt}";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $fullPrompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $generatedCode = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

                // Clean up any stray markdown blocks if the model ignored our instructions
                $generatedCode = preg_replace('/^```[a-z]*\n/i', '', $generatedCode);
                $generatedCode = preg_replace('/```$/', '', $generatedCode);
                // Also clean trailing/leading newlines that might be leftovers from stripping ticks, but be careful not to strip valid code newlines. Let's just trim markdown ticks.
                $generatedCode = preg_replace('/^```.*\n/', '', $generatedCode);

                return response()->json(['code' => trim($generatedCode, "`\n\r")]);
            }

            Log::error('Gemini API Error: ' . $response->body());
            return response()->json(['error' => 'Failed to reach Gemini API. Please try again.'], 500);
        } catch (\Exception $e) {
            Log::error('Gemini Exception: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred connecting to the AI.'], 500);
        }
    }
}
