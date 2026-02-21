<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    private function guard(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Admin access only.');
        }
    }

    public function index()
    {
        $this->guard();
        $templates = Template::with('creator')->latest()->get();
        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        $this->guard();
        return view('admin.templates.create');
    }

    public function store(Request $request)
    {
        $this->guard();
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'category'    => 'required|string',
            'zip_file'    => 'required|file|mimes:zip|max:51200', // 50MB
            'thumbnail'   => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
        ]);

        // Store ZIP
        $zipPath = $request->file('zip_file')->store('templates', 'local');

        // Store thumbnail if provided
        $thumbPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbPath = $request->file('thumbnail')->store('template-thumbnails', 'public');
        }

        Template::create([
            'created_by'  => Auth::id(),
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'category'    => $request->category,
            'zip_path'    => $zipPath,
            'thumbnail'   => $thumbPath,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template "' . $request->name . '" berhasil ditambahkan!');
    }

    public function edit(Template $template)
    {
        $this->guard();
        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, Template $template)
    {
        $this->guard();
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'category'    => 'required|string',
            'zip_file'    => 'nullable|file|mimes:zip|max:51200',
            'thumbnail'   => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
        ]);

        // Replace ZIP if new one uploaded
        if ($request->hasFile('zip_file')) {
            Storage::disk('local')->delete($template->zip_path);
            $template->zip_path = $request->file('zip_file')->store('templates', 'local');
        }

        // Replace thumbnail if new one uploaded
        if ($request->hasFile('thumbnail')) {
            if ($template->thumbnail) {
                Storage::disk('public')->delete($template->thumbnail);
            }
            $template->thumbnail = $request->file('thumbnail')->store('template-thumbnails', 'public');
        }

        $template->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'category'    => $request->category,
            'zip_path'    => $template->zip_path,
            'thumbnail'   => $template->thumbnail,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template berhasil diperbarui!');
    }

    public function destroy(Template $template)
    {
        $this->guard();
        Storage::disk('local')->delete($template->zip_path);
        if ($template->thumbnail) {
            Storage::disk('public')->delete($template->thumbnail);
        }
        $template->delete();

        return back()->with('success', 'Template berhasil dihapus.');
    }
}
