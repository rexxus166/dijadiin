<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Illuminate\Support\Facades\Log;

class ScaffoldProjectService
{
    /**
     * Scaffold a new Laravel project in the specified base directory using Composer.
     *
     * @param string $projectName The sanitized project name
     * @param string $basePath The local absolute path where projects should be placed
     * @return array Status of the scaffolding process
     */
    public function generate(string $projectName, string $basePath): array
    {
        // Ensure base path exists
        if (!is_dir($basePath)) {
            mkdir($basePath, 0755, true);
        }

        $targetDir = rtrim($basePath, '/\\') . DIRECTORY_SEPARATOR . $projectName;

        // Ensure we don't overwrite an existing directory
        if (is_dir($targetDir)) {
            return [
                'success' => false,
                'message' => "Directory '{$projectName}' already exists within the base path.",
            ];
        }

        // We use the array format in Process to strictly escape all arguments automatically
        // This mitigates shell expansion injection risks.
        // It runs: composer create-project laravel/laravel <projectName>
        $process = new Process([
            'composer',
            'create-project',
            'laravel/laravel',
            $projectName
        ], null, ['HOME' => '/tmp', 'COMPOSER_HOME' => '/tmp/composer', 'COMPOSER_MEMORY_LIMIT' => '-1'] + $_ENV);

        $process->setWorkingDirectory($basePath);

        // Composer downloads can be slow; allow 10 minutes timeout (60x10)
        $process->setTimeout(600);

        try {
            // run execution synchronously for now
            // Future updates might want to capture output iteratively using run(function($type, $buffer))
            $process->mustRun();

            return [
                'success' => true,
                'message' => "Laravel project scaffolded successfully.",
                'path' => $targetDir,
                'output' => $process->getOutput(),
            ];
        } catch (ProcessTimedOutException $e) {
            Log::error("Scaffolding timed out: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Scaffolding process timed out. Composer might be hanging.',
            ];
        } catch (ProcessFailedException $e) {
            Log::error("Scaffolding failed: " . $e->getMessage());
            // It could be that composer is not in PATH.
            return [
                'success' => false,
                'message' => 'Composer failed. Please ensure composer is installed and accessible in the system path. ' . $process->getErrorOutput(),
            ];
        } catch (\Exception $e) {
            Log::error("Scaffolding exceptional error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An unexpected error occurred during scaffolding: ' . $e->getMessage(),
            ];
        }
    }
    public function generateWithStream(string $projectName, string $basePath, callable $callback): array
    {
        if (!is_dir($basePath)) {
            mkdir($basePath, 0755, true);
        }

        $targetDir = rtrim($basePath, '/\\') . DIRECTORY_SEPARATOR . $projectName;

        if (is_dir($targetDir)) {
            return ['success' => false, 'message' => "Directory '{$projectName}' already exists within the base path."];
        }

        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $composerCmd = ['composer'];

        // Robust path resolution for Windows (especially Laragon users) to prevent command not found errors
        // Bypassing .bat wrappers entirely by executing composer.phar with the active PHP_BINARY
        if ($isWindows) {
            $laragonPaths = [
                'D:\\laragon\\bin\\composer\\composer.phar',
                'C:\\laragon\\bin\\composer\\composer.phar'
            ];
            foreach ($laragonPaths as $path) {
                if (file_exists($path)) {
                    $composerCmd = [PHP_BINARY, $path];
                    break;
                }
            }
        }

        $processArgs = array_merge($composerCmd, ['create-project', 'laravel/laravel', $projectName]);

        // Strictly limit environment variables passed to the child Composer / Artisan processes
        // This prevents the parent Laravel application (dijadiin) variables like APP_KEY, APP_ENV
        // from leaking into the newly minted application and causing 'artisan key:generate' to abort or fail.
        $env = [];
        $allowedSystemVars = ['PATH', 'TEMP', 'TMP', 'APPDATA', 'SystemRoot', 'SystemDrive', 'SystemDirectory', 'COMSPEC', 'PATHEXT', 'USERNAME', 'USERPROFILE', 'HOME'];

        foreach ($allowedSystemVars as $key) {
            $val = getenv($key) ?: ($_SERVER[$key] ?? ($_ENV[$key] ?? null));
            if ($val !== null) {
                $env[$key] = $val;
            }
        }

        if ($isWindows) {
            // Critical fallbacks for cURL DNS resolution and temp extraction in sterile Laragon web server environments
            $env['PATH'] = $env['PATH'] ?? 'C:\\Windows\\System32;C:\\Windows';
            $env['TEMP'] = $env['TEMP'] ?? 'C:\\Windows\\Temp';
            $env['TMP'] = $env['TMP'] ?? 'C:\\Windows\\Temp';
            $env['APPDATA'] = $env['APPDATA'] ?? 'C:\\Windows\\Temp';
            $env['SystemRoot'] = $env['SystemRoot'] ?? 'C:\\Windows';
            $env['SystemDrive'] = $env['SystemDrive'] ?? 'C:';
            $env['COMPOSER_HOME'] = $env['COMPOSER_HOME'] ?? $env['APPDATA'] . '\\Composer';
        } else {
            // Fallbacks for Linux/Docker environments where www-data might lack HOME
            $env['HOME'] = $env['HOME'] ?? '/tmp';
            $env['COMPOSER_HOME'] = $env['COMPOSER_HOME'] ?? '/tmp/composer';
            // Ensure PATH is always available on linux
            $env['PATH'] = $env['PATH'] ?? getenv('PATH') ?: '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin';
        }

        // Disable composer memory limit to prevent OOM errors during heavy extraction phases
        $env['COMPOSER_MEMORY_LIMIT'] = '-1';

        $process = new Process($processArgs, null, $env);

        $process->setWorkingDirectory($basePath);
        $process->setTimeout(600); // 10 minutes

        try {
            // Provide the stream callback directly to the process
            $process->run($callback);

            // Wait for composer to truly finish before returning success
            if (!$process->isSuccessful()) {
                $errorDetails = $process->getErrorOutput() ?: 'Unknown composer failure. Status code: ' . $process->getExitCode();
                return ['success' => false, 'message' => "Composer execution failed: " . $errorDetails];
            }

            return ['success' => true, 'message' => "Laravel project scaffolded.", 'path' => $targetDir];
        } catch (\Exception $e) {
            Log::error("Scaffolding exceptional error: " . $e->getMessage());
            return ['success' => false, 'message' => 'An unexpected error occurred: ' . $e->getMessage()];
        }
    }
}
