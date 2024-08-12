<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Toon een lijst van de users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.dashboard', compact('users'));
    }

    /**
     * Promote een gebruiker tot admin.
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
     * Maak een nieuwe admin account aan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createAdmin(Request $request)
    {
        // Validatie van de invoer
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Log::info('Attempting to create a new admin account with email: ' . $request->email);

        // Maak een nieuwe gebruiker aan met de rol admin
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Zorg ervoor dat de rol wordt ingesteld op 'admin'
        ]);

        // Controleer of de gebruiker correct is aangemaakt en opgeslagen
        if ($user) {
            Log::info('New admin created successfully: ' . $user->email . ' with role: ' . $user->role);
        } else {
            Log::error('Failed to create new admin with email: ' . $request->email);
        }

        return redirect()->route('admin.dashboard')->with('success', 'New admin created successfully');
    }
}

