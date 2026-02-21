<?php

namespace App\Http\Controllers;

use App\Models\UserApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiKeyController extends Controller
{
    public function index()
    {
        $keys = UserApiKey::where('user_id', Auth::id())->latest()->get();
        return view('page.api-keys.index', compact('keys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label'   => 'required|string|max:100',
            'api_key' => 'required|string|min:10',
        ]);

        UserApiKey::create([
            'user_id' => Auth::id(),
            'label'   => $request->label,
            'api_key' => $request->api_key,
            'is_active' => true,
        ]);

        return back()->with('success', 'API Key berhasil ditambahkan.');
    }

    public function update(Request $request, UserApiKey $apiKey)
    {
        abort_if($apiKey->user_id !== Auth::id(), 403);

        $request->validate([
            'label'     => 'required|string|max:100',
            'api_key'   => 'required|string|min:10',
            'is_active' => 'boolean',
        ]);

        $apiKey->update([
            'label'     => $request->label,
            'api_key'   => $request->api_key,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'API Key berhasil diperbarui.');
    }

    public function destroy(UserApiKey $apiKey)
    {
        abort_if($apiKey->user_id !== Auth::id(), 403);

        $apiKey->delete();

        return back()->with('success', 'API Key berhasil dihapus.');
    }

    public function setActive(UserApiKey $apiKey)
    {
        abort_if($apiKey->user_id !== Auth::id(), 403);

        // Deactivate all, then activate the chosen one
        UserApiKey::where('user_id', Auth::id())->update(['is_active' => false]);
        $apiKey->update(['is_active' => true]);

        return back()->with('success', 'API Key "' . $apiKey->label . '" sekarang aktif.');
    }
}
