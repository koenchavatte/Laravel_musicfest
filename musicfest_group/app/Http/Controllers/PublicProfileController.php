<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    /**
     * Toon een openbaar profiel op basis van de gebruikersnaam.
     *
     * @param string $username
     * @return \Illuminate\View\View
     */
    public function show($username)
    {
        // Zoek de gebruiker op basis van de gebruikersnaam
        $user = User::where('name', $username)->firstOrFail();

        return view('profile.public_show', compact('user'));
    }

    /**
     * Zoek gebruikers op basis van hun naam.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Zoek gebruikers op basis van een gedeeltelijke match met de naam
        $users = User::where('name', 'like', "%{$query}%")->get();

        return view('profile.search_results', compact('users'));
    }
}
