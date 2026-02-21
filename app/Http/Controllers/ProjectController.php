<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\GeneratedProject;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = GeneratedProject::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('page.projects.index', compact('projects'));
    }

    public function destroy(GeneratedProject $project)
    {
        // Authorize: only the owner can delete
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus proyek ini.');
        }

        // Remove directory from disk if it exists
        if ($project->path && File::isDirectory($project->path)) {
            File::deleteDirectory($project->path);
        }

        $project->delete();

        return back()->with('success', 'Proyek "' . $project->name . '" berhasil dihapus.');
    }
}
