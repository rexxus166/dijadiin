<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserApiKey extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'api_key',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the single active Gemini API key for the given user.
     * Falls back to .env GEMINI_API_KEY if none found in database.
     */
    public static function resolveForUser(int $userId): string
    {
        $key = static::where('user_id', $userId)
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->value('api_key');

        return $key ?: (env('GEMINI_API_KEY') ?? '');
    }

    /**
     * Return ALL available keys for this user in priority order:
     * 1. Active key first
     * 2. Then remaining inactive keys
     * 3. Finally .env key as ultimate fallback
     * Used for automatic failover when a key hits 429 or errors.
     */
    public static function resolveAllForUser(int $userId): array
    {
        $dbKeys = static::where('user_id', $userId)
            ->orderByDesc('is_active') // active = 1 comes first
            ->orderByDesc('created_at')
            ->pluck('api_key')
            ->toArray();

        // Append .env fallback key if not already in list
        $envKey = env('GEMINI_API_KEY') ?? '';
        if ($envKey && !in_array($envKey, $dbKeys)) {
            $dbKeys[] = $envKey;
        }

        return array_values(array_filter($dbKeys));
    }
}
