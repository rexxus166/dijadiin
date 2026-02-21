<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectGeneratorController;
use App\Http\Controllers\ProjectExplorerController;
use App\Http\Controllers\ProjectStreamController;
use App\Http\Controllers\GeminiChatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects', [ProjectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/admin/dashboard', function (\Illuminate\Http\Request $request) {
    if ($request->user()->role !== 'admin') {
        return redirect()->route('dashboard');
    }

    $totalUsers = \App\Models\User::where('role', '!=', 'admin')->count();
    $totalProjects = \App\Models\GeneratedProject::count();
    $recentProjects = \App\Models\GeneratedProject::with('user')->orderBy('created_at', 'desc')->take(5)->get();

    return view('admin.dashboard.index', compact('totalUsers', 'totalProjects', 'recentProjects'));
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::get('/admin/users', function (\Illuminate\Http\Request $request) {
    if ($request->user()->role !== 'admin') {
        return redirect()->route('dashboard');
    }

    $totalUsers = \App\Models\User::where('role', '!=', 'admin')->count();
    $newUsersThisWeek = \App\Models\User::where('role', '!=', 'admin')
        ->where('created_at', '>=', now()->startOfWeek())
        ->count();

    $query = \App\Models\User::where('id', '!=', $request->user()->id)
        ->withCount('generatedProjects');

    // Filter by search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'ilike', '%' . $search . '%')
                ->orWhere('email', 'ilike', '%' . $search . '%');
        });
    }

    // Filter by role
    if ($request->filled('role') && strtolower($request->role) !== 'all roles') {
        $query->where('role', strtolower($request->role));
    }

    // Filter by status computationally (Online, Offline, Suspended)
    if ($request->filled('status') && strtolower($request->status) !== 'status: all' && strtolower($request->status) !== 'all') {
        $statusFilter = strtolower($request->status);
        if ($statusFilter === 'suspended') {
            $query->where('status', 'suspended');
        } elseif ($statusFilter === 'online') {
            $query->where('status', '!=', 'suspended')
                ->whereExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('sessions')
                        ->whereColumn('sessions.user_id', 'users.id')
                        ->where('last_activity', '>=', now()->subMinutes(5)->timestamp);
                });
        } elseif ($statusFilter === 'offline') {
            $query->where('status', '!=', 'suspended')
                ->whereNotExists(function ($query) {
                    $query->select(\Illuminate\Support\Facades\DB::raw(1))
                        ->from('sessions')
                        ->whereColumn('sessions.user_id', 'users.id')
                        ->where('last_activity', '>=', now()->subMinutes(5)->timestamp);
                });
        }
    }

    $users = $query->latest('updated_at')->paginate(5)->withQueryString();

    return view('admin.user.index', compact('totalUsers', 'newUsersThisWeek', 'users'));
})->middleware(['auth', 'verified'])->name('admin.users.index');

Route::post('/admin/users', function (\Illuminate\Http\Request $request) {
    if ($request->user()->role !== 'admin') {
        return redirect()->route('dashboard');
    }

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . \App\Models\User::class],
        'role' => ['required', 'string', \Illuminate\Validation\Rule::in(['admin', 'user'])],
        'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
    ]);

    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role'],
        'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        'status' => 'active',
    ]);

    return back()->with('status', 'User created successfully.');
})->middleware(['auth', 'verified'])->name('admin.users.store');

Route::patch('/admin/users/{user}/suspend', function (\Illuminate\Http\Request $request, \App\Models\User $user) {
    if ($request->user()->role !== 'admin') {
        return redirect()->route('dashboard');
    }

    // Only require reason when suspending, not when reactivating
    if ($user->status !== 'suspended') {
        $request->validate(['reason' => ['required', 'string', 'max:255']]);
    }

    $user->update(['status' => $user->status === 'suspended' ? 'active' : 'suspended']);
    return back()->with('status', 'User status updated successfully.');
})->middleware(['auth', 'verified'])->name('admin.users.suspend');

Route::delete('/admin/users/{user}', function (\Illuminate\Http\Request $request, \App\Models\User $user) {
    if ($request->user()->role !== 'admin') {
        return redirect()->route('dashboard');
    }

    $request->validateWithBag('userDeletion', [
        'password' => ['required', 'current_password'],
    ]);

    $user->delete();
    return back()->with('status', 'User deleted successfully.');
})->middleware(['auth', 'verified'])->name('admin.users.destroy');

Route::middleware('auth')->group(function () {
    // AI Builder Project Generator Routes
    Route::get('/ai-builder', [ProjectGeneratorController::class, 'index'])->name('project.generator.index');
    Route::post('/ai-builder/generate', [ProjectGeneratorController::class, 'store'])->name('project.generator.store');
    Route::get('/ai-builder/stream', [ProjectStreamController::class, 'stream'])->name('project.generator.stream');

    // Web File Explorer Routes
    Route::get('/ai-builder/explorer/{project}', [ProjectExplorerController::class, 'index'])->name('project.explorer.index');
    Route::get('/ai-builder/explorer/{project}/tree', [ProjectExplorerController::class, 'tree'])->name('project.explorer.tree');
    Route::get('/ai-builder/explorer/{project}/file', [ProjectExplorerController::class, 'file'])->name('project.explorer.file');
    Route::put('/ai-builder/explorer/{project}/save-file', [ProjectExplorerController::class, 'saveFile'])->name('project.explorer.saveFile');

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
