<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('page.profile.index', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('avatars', 'public');
            $fullPath = 'storage/' . $path;

            $customAvatars = is_array($user->custom_avatars) ? $user->custom_avatars : [];
            if (!in_array($fullPath, $customAvatars)) {
                array_unshift($customAvatars, $fullPath);
                $user->custom_avatars = array_slice($customAvatars, 0, 10);
            }

            $user->avatar = $fullPath;
        } elseif ($request->filled('avatar_path')) {
            $user->avatar = $request->avatar_path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete a custom avatar from user's list.
     */
    public function destroyAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();
        $pathToDelete = $request->input('avatar_path');

        $customAvatars = is_array($user->custom_avatars) ? $user->custom_avatars : [];

        if (($key = array_search($pathToDelete, $customAvatars)) !== false) {
            unset($customAvatars[$key]);
            $user->custom_avatars = array_values($customAvatars);

            if ($user->avatar === $pathToDelete) {
                // Determine fallback: previously selected custom avatar or default
                $user->avatar = count($user->custom_avatars) > 0 ? $user->custom_avatars[0] : 'assets/avatar/avatar-1.png';
            }

            $user->save();

            if (str_starts_with($pathToDelete, 'storage/')) {
                $relativePath = substr($pathToDelete, 8);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath);
            }
        }

        return Redirect::route('profile.edit')->with('status', 'avatar-deleted');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
