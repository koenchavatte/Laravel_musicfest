<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\HomeController;
use Laravel\Jetstream\Http\Controllers\AuthenticatedSessionController;
use Laravel\Jetstream\Http\Controllers\RegisteredUserController;
use Laravel\Jetstream\Http\Controllers\PasswordResetLinkController;
use Laravel\Jetstream\Http\Controllers\NewPasswordController;
use Laravel\Jetstream\Http\Controllers\EmailVerificationPromptController;
use Laravel\Jetstream\Http\Controllers\VerifyEmailController;
use Laravel\Jetstream\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Jetstream\Http\Controllers\ConfirmablePasswordController;
use Laravel\Jetstream\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Jetstream\Http\Controllers\TwoFactorAuthenticationController;

Route::get('/', [HomeController::class, 'index'])->name('home');

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
    Route::resource('news', NewsController::class)->except(['show']);
});

// Route voor het weergeven van een individueel nieuwsbericht
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

// Publieke profielroutes
Route::get('/profile/{username}', [PublicProfileController::class, 'show'])->name('profile.public.show');

// Zoekfunctie voor de search bar
Route::get('/search', [PublicProfileController::class, 'search'])->name('profile.search');

// Jetstream Authentication Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware(['guest'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware(['guest']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware(['auth'])->name('logout');
Route::get('/register', [RegisteredUserController::class, 'create'])->middleware(['guest'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware(['guest']);
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->middleware(['guest'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware(['guest'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->middleware(['guest'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware(['guest'])->name('password.update');
Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])->middleware(['auth'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])->middleware(['auth'])->name('password.confirm');
Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])->middleware(['auth']);
Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])->middleware(['auth'])->name('password.confirmation');
Route::post('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])->middleware(['auth', 'password.confirm']);
Route::delete('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])->middleware(['auth', 'password.confirm']);
