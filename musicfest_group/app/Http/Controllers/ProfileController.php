<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'birthdate' => 'nullable|date', // Validatie voor geboortedatum
        ]);

        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->birthdate = $request->birthdate; // Opslaan van geboortedatum

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }
}
