<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class ProjectExplorerController extends Controller
{
    /**
     * Build the base storage path for the authenticated user using their ID.
     */
    private function basePath(): string
    {
        return storage_path('app/generated_projects/' . Auth::id());
    }

    public function index(string $project)
    {
        $projectData = \App\Models\GeneratedProject::where('name', $project)->first();

        return view('page.generator.explorer', [
            'projectName'        => $project,
            'aiPrompt'           => $projectData ? $projectData->ai_prompt : '',
            'projectDescription' => $projectData ? $projectData->description : ''
        ]);
    }

    public function tree(Request $request, string $project)
    {
        $basePath    = $this->basePath();
        $projectPath = realpath($basePath . DIRECTORY_SEPARATOR . $project);

        if (!$projectPath || !str_starts_with($projectPath, realpath($basePath))) {
            return response()->json(['error' => 'Invalid project or path traversal attempt.'], 403);
        }

        $tree = $this->buildTree($projectPath, $projectPath);
        return response()->json($tree);
    }

    private function buildTree($dir, $projectPath)
    {
        $dirs  = [];
        $files = [];

        $cdir = scandir($dir);
        foreach ($cdir as $value) {
            if (!in_array($value, ['.', '..', '.git', 'vendor', 'node_modules'])) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $dirs[] = [
                        'name'     => $value,
                        'type'     => 'directory',
                        'children' => $this->buildTree($dir . DIRECTORY_SEPARATOR . $value, $projectPath)
                    ];
                } else {
                    $files[] = [
                        'name' => $value,
                        'type' => 'file',
                        'path' => str_replace('\\', '/', ltrim(str_replace($projectPath, '', realpath($dir . DIRECTORY_SEPARATOR . $value)), '/\\'))
                    ];
                }
            }
        }

        usort($dirs,  fn($a, $b) => strcasecmp($a['name'], $b['name']));
        usort($files, fn($a, $b) => strcasecmp($a['name'], $b['name']));

        return array_merge($dirs, $files);
    }

    public function file(Request $request, string $project)
    {
        $filePathQuery = $request->query('path');
        if (!$filePathQuery) {
            return response()->json(['error' => 'Path is required'], 400);
        }

        $basePath    = $this->basePath();
        $projectPath = realpath($basePath . DIRECTORY_SEPARATOR . $project);

        if (!$projectPath || !str_starts_with($projectPath, realpath($basePath))) {
            return response()->json(['error' => 'Invalid project.'], 403);
        }

        $requestedFile = realpath($projectPath . DIRECTORY_SEPARATOR . str_replace(['../', '..\\'], '', $filePathQuery));

        if (!$requestedFile || !str_starts_with($requestedFile, $projectPath)) {
            return response()->json(['error' => 'Invalid file or path traversal attempt.'], 403);
        }

        if (!is_file($requestedFile)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        $content = file_get_contents($requestedFile);
        return response()->json(['content' => mb_convert_encoding($content, 'UTF-8', 'UTF-8')]);
    }

    public function saveFile(Request $request, string $project)
    {
        $filePathQuery = $request->input('path');
        $newContent    = $request->input('content');

        if (!$filePathQuery || $newContent === null) {
            return response()->json(['error' => 'Path and content are required'], 400);
        }

        $basePath    = $this->basePath();
        $projectPath = realpath($basePath . DIRECTORY_SEPARATOR . $project);

        if (!$projectPath || !str_starts_with($projectPath, realpath($basePath))) {
            return response()->json(['error' => 'Invalid project.'], 403);
        }

        $requestedFile = realpath($projectPath . DIRECTORY_SEPARATOR . str_replace(['../', '..\\'], '', $filePathQuery));

        if (!$requestedFile || !str_starts_with($requestedFile, $projectPath)) {
            return response()->json(['error' => 'Invalid file or path traversal attempt.'], 403);
        }

        if (!is_file($requestedFile)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        file_put_contents($requestedFile, $newContent);

        return response()->json(['success' => true]);
    }

    public function download(Request $request, string $project)
    {
        $basePath    = $this->basePath();
        $projectPath = realpath($basePath . DIRECTORY_SEPARATOR . $project);

        if (!$projectPath || !str_starts_with($projectPath, realpath($basePath))) {
            abort(403, 'Invalid project path.');
        }

        $zipFilePath = $basePath . DIRECTORY_SEPARATOR . $project . '.zip';

        $zip = new \ZipArchive();
        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($projectPath),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath     = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($projectPath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
        } else {
            return back()->with('error', 'Failed to create zip file.');
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function lint(Request $request, string $project)
    {
        $filePathQuery = $request->query('path');
        if (!$filePathQuery) {
            return response()->json(['errors' => [], 'ok' => true]);
        }

        $basePath    = $this->basePath();
        $projectPath = realpath($basePath . DIRECTORY_SEPARATOR . $project);

        if (!$projectPath || !str_starts_with($projectPath, realpath($basePath))) {
            return response()->json(['errors' => [], 'ok' => true]);
        }

        $requestedFile = realpath($projectPath . DIRECTORY_SEPARATOR . str_replace(['../', '..\\'], '', $filePathQuery));

        if (!$requestedFile || !str_starts_with($requestedFile, $projectPath) || !is_file($requestedFile)) {
            return response()->json(['errors' => [], 'ok' => true]);
        }

        $ext    = strtolower(pathinfo($requestedFile, PATHINFO_EXTENSION));
        $errors = [];

        // ── PHP / Blade ──────────────────────────────────────────────────────────
        if ($ext === 'php') {
            $output   = [];
            $exitCode = 0;
            exec('php -l ' . escapeshellarg($requestedFile) . ' 2>&1', $output, $exitCode);

            if ($exitCode !== 0) {
                // Parse: "Parse error: ... in /path/file.php on line 42"
                foreach ($output as $line) {
                    if (preg_match('/^(Parse error|Fatal error|syntax error)[^\n]*on line (\d+)/i', $line, $m)) {
                        $errors[] = ['line' => (int) $m[2], 'message' => trim($line)];
                    } elseif (!empty($line) && !str_starts_with($line, 'No syntax')) {
                        // Include raw line if it's an error but doesn't match pattern
                        $errors[] = ['line' => null, 'message' => trim($line)];
                    }
                }
                if (empty($errors)) {
                    $errors[] = ['line' => null, 'message' => implode(' ', $output)];
                }
            }
        }

        // ── JSON ─────────────────────────────────────────────────────────────────
        elseif ($ext === 'json') {
            $content = file_get_contents($requestedFile);
            json_decode($content);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Attempt to find the error line
                $lines   = explode("\n", $content);
                $errLine = null;
                $pos     = 0;
                $needle  = json_last_error_msg();
                // Rough line estimation: find first invalid char after progressive decode attempts
                foreach ($lines as $i => $ln) {
                    $pos += strlen($ln) + 1;
                }
                $errors[] = ['line' => null, 'message' => 'JSON Error: ' . json_last_error_msg()];
            }
        }

        // ── JavaScript ───────────────────────────────────────────────────────────
        elseif ($ext === 'js' || $ext === 'mjs' || $ext === 'cjs') {
            // Try node --check if available
            $output   = [];
            $exitCode = 0;
            exec('node --check ' . escapeshellarg($requestedFile) . ' 2>&1', $output, $exitCode);
            if ($exitCode !== 0 && !empty($output)) {
                foreach ($output as $line) {
                    if (preg_match('/^[^\n]*:(\d+)/', $line, $m)) {
                        $errors[] = ['line' => (int) $m[1], 'message' => trim($line)];
                    } elseif (!empty(trim($line))) {
                        $errors[] = ['line' => null, 'message' => trim($line)];
                    }
                }
            }
        }

        // ── HTML / Blade ─────────────────────────────────────────────────────────
        elseif (in_array($ext, ['html', 'htm', 'blade'])) {
            $content = file_get_contents($requestedFile);
            $lines   = explode("\n", $content);

            // Simple unmatched tag check using a small heuristic
            $openTags  = [];
            $voidTags  = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr'];
            foreach ($lines as $lineNum => $ln) {
                // Find all tags in line
                preg_match_all('/<\/?([a-zA-Z][a-zA-Z0-9]*)[^>]*\/?>/u', $ln, $matches, PREG_SET_ORDER);
                foreach ($matches as $match) {
                    $tag  = strtolower($match[1]);
                    $full = $match[0];
                    if (in_array($tag, $voidTags)) continue;
                    if (str_starts_with($full, '</')) {
                        // Closing tag
                        $last = end($openTags);
                        if ($last && $last['tag'] === $tag) {
                            array_pop($openTags);
                        }
                        // Don't flag mismatches as they're too noisy with templates
                    } elseif (!str_ends_with(rtrim($full), '/>')) {
                        $openTags[] = ['tag' => $tag, 'line' => $lineNum + 1];
                    }
                }
            }
        }

        return response()->json([
            'ok'     => empty($errors),
            'errors' => $errors,
        ]);
    }

    public function startPreview(Request $request, string $project)
    {
        $basePath    = $this->basePath();
        $projectPath = realpath($basePath . DIRECTORY_SEPARATOR . $project);

        if (!$projectPath || !str_starts_with($projectPath, realpath($basePath))) {
            return response()->json(['success' => false, 'message' => 'Invalid project path.']);
        }

        $userId = Auth::id() ?? 1;
        $port = 8001; // Gunakan port spesifik agar bisa mati otomatis dan di-reuse

        // Stop process apapun yang mungkin sedang jalan di port 8001 (baik dari GUI atau terminal manual)
        $this->killProcessOnPort($port);

        // Composer install if vendor not exist
        if (!is_dir($projectPath . '/vendor')) {
            $process = new Process(['composer', 'install'], $projectPath);
            $process->setTimeout(300); // 5 menit
            $process->run();
            if (!$process->isSuccessful()) {
                Log::error('Composer install failed: ' . $process->getErrorOutput());
                return response()->json(['success' => false, 'message' => 'Composer install failed: ' . $process->getErrorOutput()]);
            }
        }

        // key:generate if needed
        if (!file_exists($projectPath . '/.env')) {
            if (file_exists($projectPath . '/.env.example')) {
                copy($projectPath . '/.env.example', $projectPath . '/.env');
            } else {
                file_put_contents($projectPath . '/.env', "APP_NAME=Laravel\nAPP_ENV=local\nAPP_KEY=\nAPP_DEBUG=true\nAPP_URL=http://localhost:$port\n");
            }
            $process = new Process(['php', 'artisan', 'key:generate'], $projectPath);
            $process->run();
        }

        // Run serve
        $bindHost = '0.0.0.0'; // Allow external access when on server
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $cmd = "start /B php artisan serve --host={$bindHost} --port={$port} > NUL 2>&1";
            pclose(popen("cd /d " . escapeshellarg($projectPath) . " && " . $cmd, "r"));
        } else {
            $cmd = "php artisan serve --host={$bindHost} --port={$port} > /dev/null 2>&1 &";
            exec("cd " . escapeshellarg($projectPath) . " && " . $cmd);
        }

        Cache::put("preview_port_{$userId}_{$project}", $port, now()->addHours(2));

        // Wait a little bit for server to hook the port
        sleep(2);

        // Get dynamic host
        $domain = $request->getHost();
        if ($domain === 'localhost' || $domain === '127.0.0.1') {
            // Local fallback
            $previewUrl = "http://127.0.0.1:{$port}";
        } else {
            // Cloud/Server via Kubernetes Ingress
            $previewUrl = "https://preview.{$domain}";
        }

        return response()->json([
            'success' => true,
            'url'     => $previewUrl
        ]);
    }

    public function stopPreview(Request $request, string $project)
    {
        $userId = Auth::id() ?? 1;
        $port = Cache::get("preview_port_{$userId}_{$project}");

        if ($port) {
            $this->killProcessOnPort($port);
            Cache::forget("preview_port_{$userId}_{$project}");
        }

        return response()->json(['success' => true]);
    }


    private function killProcessOnPort($port)
    {
        if (!$port) return;

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $output = [];
            exec("netstat -ano | findstr :$port", $output);
            foreach ($output as $line) {
                if (trim($line)) {
                    $parts = preg_split('/\s+/', trim($line));
                    $pid = end($parts);
                    if (is_numeric($pid) && $pid > 0) {
                        exec("taskkill /F /PID $pid");
                    }
                }
            }
        } else {
            exec("lsof -t -i:$port", $pids);
            foreach ($pids as $pid) {
                if (is_numeric($pid)) {
                    exec("kill -9 $pid");
                }
            }
        }
    }
}
