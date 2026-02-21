<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\GeneratedProject;
use App\Services\ScaffoldProjectService;
use App\Services\EnvGeneratorService;
use App\Http\Requests\GenerateProjectRequest;

class ProjectGeneratorController extends Controller
{
    public function index()
    {
        return view('page.generator.index');
    }

    public function store(GenerateProjectRequest $request, ScaffoldProjectService $scaffoldService, EnvGeneratorService $envService)
    {
        $data = $request->validated();

        $basePath = storage_path('app/generated_projects/' . Auth::id());
        $projectName = $data['project_name'];

        // 1. Scaffold the project
        $scaffoldResult = $scaffoldService->generate($projectName, $basePath);

        if (!$scaffoldResult['success']) {
            return back()->withInput()->withErrors(['project_name' => $scaffoldResult['message']]);
        }

        $projectPath = $scaffoldResult['path'];

        // 2. Configure .env
        $envResult = $envService->configureDatabaseEnv($projectPath, $data);

        if (!$envResult) {
            return back()->withInput()->withErrors(['project_name' => 'Project generated but failed to modify the .env file.']);
        }

        // 3. Save record to database
        GeneratedProject::create([
            'user_id'     => Auth::id(),
            'name'        => $projectName,
            'description' => $data['description'] ?? null,
            'db_type'     => $data['db_type'] ?? 'mysql',
            'db_name'     => $data['db_name'] ?? null,
            'db_port'     => $data['db_port'] ?? null,
            'db_username' => $data['db_username'] ?? null,
            'ai_prompt'   => $data['ai_prompt'] ?? null,
            'path'        => $projectPath,
        ]);

        // 4. Redirect to explorer
        return redirect()->route('project.explorer.index', ['project' => $projectName]);
    }
}
