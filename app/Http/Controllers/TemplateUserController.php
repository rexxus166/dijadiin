<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\GeneratedProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemplateUserController extends Controller
{
    public function index(Request $request)
    {
        $query = Template::where('is_active', true)->latest();

        if ($request->filled('category') && $request->category !== 'semua') {
            $query->where('category', $request->category);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
        }

        $templates   = $query->get();
        $categories  = Template::where('is_active', true)->distinct()->pluck('category');

        return view('page.templates.index', compact('templates', 'categories'));
    }

    public function use(Request $request, Template $template)
    {
        $request->validate([
            'project_name' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[a-z0-9\-\_]+$/'],
        ]);

        $projectName = $request->project_name;
        $userId      = Auth::id();
        $basePath    = storage_path('app/generated_projects/' . $userId);

        if (!is_dir($basePath)) {
            mkdir($basePath, 0755, true);
        }

        $projectPath = $basePath . DIRECTORY_SEPARATOR . $projectName;

        // Check if project name already taken for this user
        if (is_dir($projectPath)) {
            return back()->withErrors(['project_name' => 'Nama project sudah dipakai, pilih nama lain.']);
        }

        // Get the ZIP file path
        $zipFilePath = storage_path('app/' . $template->zip_path);
        if (!file_exists($zipFilePath)) {
            return back()->with('error', 'File template tidak ditemukan di server.');
        }

        // Extract ZIP into project folder
        $zip = new \ZipArchive();
        if ($zip->open($zipFilePath) !== TRUE) {
            return back()->with('error', 'Gagal membuka file template.');
        }

        mkdir($projectPath, 0755, true);
        $zip->extractTo($projectPath);
        $zip->close();

        // Save to DB
        GeneratedProject::create([
            'user_id'     => $userId,
            'name'        => $projectName,
            'description' => 'Dari template: ' . $template->name,
            'db_type'     => 'mysql',
            'path'        => $projectPath,
            'ai_prompt'   => null,
        ]);

        // Increment downloads count
        $template->increment('downloads');

        return redirect()
            ->route('project.explorer.index', ['project' => $projectName])
            ->with('success', 'Template "' . $template->name . '" berhasil dimuat ke project Anda!');
    }
}
