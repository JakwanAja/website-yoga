<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// Auth routes (hanya untuk tamu / belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Admin dashboard — bisa diakses admin dan super_admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})
->name('admin.dashboard')
->middleware(['auth', 'role:admin,super_admin']);

// Super Admin dashboard — hanya super_admin
Route::get('/superadmin/dashboard', function () {
    return view('superadmin.dashboard');
})
->name('superadmin.dashboard')
->middleware(['auth', 'role:super_admin']);