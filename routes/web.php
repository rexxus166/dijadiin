<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects', function (\Illuminate\Http\Request $request) {
    if ($request->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return view('page.projects.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/dashboard', function (\Illuminate\Http\Request $request) {
    if ($request->user()->role !== 'admin') {
        return redirect()->route('dashboard');
    }

    return view('admin.dashboard.index');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/avatar', [ProfileController::class, 'destroyAvatar'])->name('profile.avatar.destroy');
});

require __DIR__ . '/auth.php';
