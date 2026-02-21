<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class EnvGeneratorService
{
    /**
     * Finds and overwrites specific DB configurations in a scaffolded project's .env file.
     *
     * @param string $projectPath The absolute path to the generated project root
     * @param array $credentials Contains keys: db_type, db_name, db_username, db_password
     * @return bool True on success, false on failure
     */
    public function configureDatabaseEnv(string $projectPath, array $credentials): bool
    {
        $envPath = rtrim($projectPath, '/\\') . DIRECTORY_SEPARATOR . '.env';

        if (!file_exists($envPath)) {
            Log::error("Env file not found at: {$envPath}");
            return false;
        }

        $envContent = file_get_contents($envPath);
        if ($envContent === false) {
            return false;
        }

        $dbType = $credentials['db_type'] ?? 'mysql';
        $dbName = $credentials['db_name'] ?? 'laravel_db';
        $dbUsername = $credentials['db_username'] ?? 'root';
        $dbPassword = $credentials['db_password'] ?? '';

        // Auto-configure host and port based on db type
        $dbHost = '127.0.0.1';
        $dbPort = $credentials['db_port'] ?? ($dbType === 'pgsql' ? '5432' : '3306');

        // Safe regex replace matching key=something to key=newValue
        // We use preg_replace directly to preserve spacing/comments surrounding It.

        $replacements = [
            '/^#?\h*DB_CONNECTION=.*$/m' => "DB_CONNECTION={$dbType}",
            '/^#?\h*DB_HOST=.*$/m'       => "DB_HOST={$dbHost}",
            '/^#?\h*DB_PORT=.*$/m'       => "DB_PORT={$dbPort}",
            '/^#?\h*DB_DATABASE=.*$/m'   => "DB_DATABASE={$dbName}",
            '/^#?\h*DB_USERNAME=.*$/m'   => "DB_USERNAME={$dbUsername}",
            '/^#?\h*DB_PASSWORD=.*$/m'   => "DB_PASSWORD={$dbPassword}",
        ];

        // If the user provided an AI Prompt, append it to the end of the env content
        if (!empty($credentials['ai_prompt'])) {
            $prompt = str_replace(["\r", "\n"], ' ', $credentials['ai_prompt']); // remove newlines for env file safety
            $envContent .= "\n\n# AI Builder Context\nAI_PROMPT=\"{$prompt}\"\n";
        }

        // SQLite Specific logic: DB_DATABASE usually points to an absolute file in standard Laravel, or sqlite memory
        if ($dbType === 'sqlite') {
            // Usually Laravel expects database/database.sqlite to exist if DB_CONNECTION=sqlite (in older versions). 
            // In Laravel 11+, sqlite is the default so just updating the connection may be enough.
            $replacements['/^#?\h*DB_DATABASE=.*$/m']   = "DB_DATABASE=database/database.sqlite";
            // Make sure the file exists if it doesn't
            $sqliteFile = rtrim($projectPath, '/\\') . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'database.sqlite';
            if (!file_exists($sqliteFile)) {
                @touch($sqliteFile);
            }
        }

        $envContent = preg_replace(array_keys($replacements), array_values($replacements), $envContent);

        // Save it back to disk
        $result = file_put_contents($envPath, $envContent);

        return $result !== false;
    }
}
