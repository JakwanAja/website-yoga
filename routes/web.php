<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// ── Halaman Publik ──────────────────────────────────────────
Route::view('/', 'beranda')->name('home');
Route::view('/kelas', 'kelas')->name('kelas');

// ── Auth ────────────────────────────────────────────────────
Route::get('/redirect-login', [LoginController::class, 'redirectIfAuthenticated'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Admin (publik, tanpa auth) ───────────────────────────────
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// ── Admin (butuh auth) ───────────────────────────────────────
Route::prefix('admin')
    ->middleware(['auth', 'role:admin,superadmin'])
    ->group(function () {
        Route::get('/jadwal',  fn() => view('admin.jadwal'))->name('admin.jadwal');
        Route::get('/verifikasi',    fn() => view('admin.verifikasi'))->name('admin.verifikasi');
        Route::get('/booking', fn() => view('admin.booking'))->name('admin.booking');
    });