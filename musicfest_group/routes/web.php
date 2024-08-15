<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\HomeController; // Toegevoegd voor de homepagina

Route::get('/', [HomeController::class, 'index'])->name('home'); // Veranderd naar HomeController

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// Profielroutes voor ingelogde gebruikers
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/promote/{user}', [AdminController::class, 'promoteToAdmin'])->name('admin.promote');
    Route::post('/admin/create', [AdminController::class, 'createAdmin'])->name('admin.create');

    // Routes voor nieuwsbeheer
    Route::resource('news', NewsController::class)->except(['show']); // Alles behalve de 'show' route
});

// Publieke profielroutes
Route::get('/profile/{username}', [PublicProfileController::class, 'show'])->name('profile.public.show');

// Zoekfunctie
Route::get('/search', [PublicProfileController::class, 'search'])->name('profile.search');
