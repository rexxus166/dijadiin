<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\UserApiKey;

class GeminiService
{
    const GEMINI_URL = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent';

    /**
     * Call Gemini API with automatic failover across all user API keys.
     * If a key returns 429 (rate limit) or a server error, retries with the next key.
     *
     * @param int         $userId       Authenticated user ID
     * @param string      $systemPrompt System instruction
     * @param string      $userPrompt   User message
     * @param int         $timeout      HTTP timeout in seconds
     * @return array{success: bool, text: ?string, error: ?string, key_used: ?string}
     */
    public static function call(
        int $userId,
        string $systemPrompt,
        string $userPrompt,
        int $timeout = 90
    ): array {
        $keys = UserApiKey::resolveAllForUser($userId);

        if (empty($keys)) {
            return [
                'success' => false,
                'text'    => null,
                'error'   => 'No Gemini API key configured. Please add one in API Keys settings.',
                'key_used' => null,
            ];
        }

        $lastError = 'Unknown error';

        $baseUrl = rtrim(env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta/openai'), '/');
        $endpoint = $baseUrl . '/chat/completions';
        $model = env('GEMINI_MODEL', 'gemini-2.5-flash-lite'); // Default model name

        foreach ($keys as $index => $apiKey) {
            $label = $index === 0 ? 'active key' : "fallback key #$index";

            try {
                $response = Http::withToken($apiKey)->timeout($timeout)->post(
                    $endpoint,
                    [
                        'model' => $model,
                        'messages' => [
                            ['role' => 'system', 'content' => $systemPrompt],
                            ['role' => 'user', 'content' => $userPrompt]
                        ],
                        'temperature' => 0.2,
                    ]
                );

                // Success
                if ($response->successful()) {
                    $data    = $response->json();
                    $rawText = $data['choices'][0]['message']['content'] ?? '';

                    // Strip markdown backticks if AI sneaked them in
                    $rawText = preg_replace('/^```[a-z]*\s*/mi', '', $rawText);
                    $rawText = preg_replace('/\s*```$/mi', '', $rawText);
                    $rawText = trim($rawText);

                    return [
                        'success'  => true,
                        'text'     => $rawText,
                        'error'    => null,
                        'key_used' => $label,
                    ];
                }

                // Handle non-success HTTP statuses
                $statusCode  = $response->status();
                $errorData   = $response->json();
                $errorMsg    = $errorData['error']['message'] ?? "HTTP {$statusCode}";
                $lastError   = "Gemini API [{$label}]: {$errorMsg}";

                Log::warning("GeminiService: {$lastError}");

                // Retry only on 429 (rate limit) or 5xx server errors
                if ($statusCode === 429 || $statusCode >= 500) {
                    Log::info("GeminiService: Trying next key after {$statusCode}...");
                    continue; // try next key
                }

                // For 4xx client errors (bad key, invalid request, etc.) – stop retrying
                return [
                    'success'  => false,
                    'text'     => null,
                    'error'    => $lastError,
                    'key_used' => $label,
                ];
            } catch (\Exception $e) {
                $lastError = "Exception with {$label}: " . $e->getMessage();
                Log::error("GeminiService: {$lastError}");
                continue; // try next key on network issues too
            }
        }

        // All keys exhausted
        return [
            'success'  => false,
            'text'     => null,
            'error'    => "All API keys failed. Last error: {$lastError}",
            'key_used' => null,
        ];
    }

    /**
     * Convenience: same as call() but for raw code generation.
     * Strips JSON extraction — returns raw text exactly.
     */
    public static function callRaw(
        int $userId,
        string $systemPrompt,
        string $userPrompt,
        int $timeout = 120
    ): ?string {
        $result = static::call($userId, $systemPrompt, $userPrompt, $timeout);
        return $result['success'] ? $result['text'] : null;
    }
}
