<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.dashboard', compact('users'));
    }

    /**
     * Promote a user to admin.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function promoteToAdmin(User $user)
    {
        $user->update(['role' => 'admin']);
        return redirect()->route('admin.dashboard');
    }
}
