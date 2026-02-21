<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
