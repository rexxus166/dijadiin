<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectGeneratorController;
use App\Http\Controllers\ProjectExplorerController;
use App\Http\Controllers\ProjectStreamController;
use App\Http\Controllers\GeminiChatController;
use App\Http\Controllers\AutoScaffoldController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects', [ProjectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::redirect('/dashboard', '/projects');

Route::get('/admin/dashboard', function (\Illuminate\Http\Request $request) {
    if ($request->user()->role !== 'admin') {
        return redirect()->route('dashboard');
    }

    return view('admin.dashboard.index');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    // AI Builder Project Generator Routes
    Route::get('/ai-builder/create', [ProjectGeneratorController::class, 'index'])->name('project.generator.index');
    Route::post('/ai-builder/generate', [ProjectGeneratorController::class, 'store'])->name('project.generator.store');
    Route::get('/ai-builder/stream', [ProjectStreamController::class, 'stream'])->name('project.generator.stream');

    // Web File Explorer Routes
    Route::get('/ai-builder/explorer/{project}', [ProjectExplorerController::class, 'index'])->name('project.explorer.index');
    Route::get('/ai-builder/explorer/{project}/tree', [ProjectExplorerController::class, 'tree'])->name('project.explorer.tree');
    Route::get('/ai-builder/explorer/{project}/file', [ProjectExplorerController::class, 'file'])->name('project.explorer.file');
    Route::put('/ai-builder/explorer/{project}/save-file', [ProjectExplorerController::class, 'saveFile'])->name('project.explorer.saveFile');
    Route::get('/ai-builder/auto-scaffold', [AutoScaffoldController::class, 'stream'])->name('project.generator.auto-scaffold');

    // Gemini Chat API
    Route::post('/ai-builder/chat', [GeminiChatController::class, 'chat'])->name('gemini.chat');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/avatar', [ProfileController::class, 'destroyAvatar'])->name('profile.avatar.destroy');

    // Project management
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});

require __DIR__ . '/auth.php';
