<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * toon een lijst van de users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.dashboard', compact('users'));
    }

    /**
     * promote een gebruiker tot admin.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function promoteToAdmin(User $user)
    {
        Log::info('Promoting user to admin: ' . $user->email);

        $user->role = 'admin';
        $user->save();

        Log::info('User role after update: ' . $user->role);

        return redirect()->route('admin.dashboard')->with('success', 'User promoted to admin successfully');
    }

    /**
     * maak een nieuwe admin account aan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Maak een nieuwe gebruiker aan met de rol admin
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        Log::info('New admin created: ' . $user->email);

        return redirect()->route('admin.dashboard')->with('success', 'New admin created successfully');
    }
}
