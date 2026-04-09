<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// ─── PUBLIC ───────────────────────────────────────────
Route::get('/',        [PublicController::class, 'landing'])->name('home');
Route::get('/jadwal',  [PublicController::class, 'jadwal'])->name('jadwal');
Route::get('/booking', [PublicController::class, 'booking'])->name('booking');

// ─── AUTH ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ─── ADMIN ────────────────────────────────────────────
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware(['auth', 'role:admin,super_admin']);

Route::get('/superadmin/dashboard', function () {
    return view('superadmin.dashboard');
})->name('superadmin.dashboard')->middleware(['auth', 'role:super_admin']);