<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// ── Halaman Publik ──────────────────────────────────────────
Route::view('/', 'beranda')->name('home');
Route::view('/kelas', 'kelas')->name('kelas');

// ── Auth ────────────────────────────────────────────────────
Route::get('/login', [LoginController::class, 'redirectIfAuthenticated'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Admin (butuh auth + role admin/superadmin) ───────────────
Route::prefix('admin')
    ->middleware(['auth', 'role:admin,superadmin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Halaman yang bisa diakses admin & superadmin
        Route::get('/jadwal',    fn() => view('admin.jadwal'))->name('admin.jadwal');
        Route::get('/verifikasi', fn() => view('admin.verifikasi'))->name('admin.verifikasi');
        Route::get('/booking',   fn() => view('admin.booking'))->name('admin.booking');
    });

// ── Super Admin only ─────────────────────────────────────────
Route::prefix('admin')
    ->middleware(['auth', 'role:superadmin'])
    ->group(function () {

        // Kelola akun admin (tambah admin baru, dll.)
        Route::get('/kelola-admin', fn() => view('admin.kelola-admin'))->name('admin.kelola-admin');
        Route::get('/laporan',      fn() => view('admin.laporan'))->name('admin.laporan');
        Route::get('/pengaturan',   fn() => view('admin.pengaturan'))->name('admin.pengaturan');
    });