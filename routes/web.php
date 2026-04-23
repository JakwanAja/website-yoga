<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\JadwalKelas;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Share $jadwals ke semua view publik
|--------------------------------------------------------------------------
*/
View::composer(['beranda', 'kelas', 'layouts.app'], function ($view) {
    $view->with('jadwals', JadwalKelas::where('status', 1)->orderBy('hari')->get());
});

// ── Halaman Publik ──────────────────────────────────────────
Route::view('/', 'beranda')->name('home');
Route::view('/kelas', 'kelas')->name('kelas');

// ── Booking Publik ──────────────────────────────────────────
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// ── Auth ────────────────────────────────────────────────────
Route::get('/login', [LoginController::class, 'redirectIfAuthenticated'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// ── Admin ────────────────────────────────────────────────────
Route::prefix('admin')
    ->middleware(['auth', 'role:admin,superadmin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/jadwal', fn() => view('admin.jadwal'))->name('admin.jadwal');
        Route::get('/kelas',  fn() => view('admin.kelas'))->name('admin.kelas');

        // Booking CRUD
        Route::get('/booking',                   [BookingController::class, 'index'])       ->name('admin.booking');
        Route::get('/booking/{id}/edit',         [BookingController::class, 'edit'])        ->name('admin.booking.edit');
        Route::put('/booking/{id}',              [BookingController::class, 'update'])      ->name('admin.booking.update');
        Route::patch('/booking/{id}/status',     [BookingController::class, 'updateStatus'])->name('admin.booking.status');
        Route::delete('/booking/{id}',           [BookingController::class, 'destroy'])     ->name('admin.booking.destroy');
    });

// ── Super Admin ──────────────────────────────────────────────
Route::prefix('admin')
    ->middleware(['auth', 'role:superadmin'])
    ->group(function () {
        Route::get('/kelola-admin', fn() => view('admin.kelola-admin'))->name('admin.kelola-admin');
        Route::get('/laporan',      fn() => view('admin.laporan'))     ->name('admin.laporan');
        Route::get('/pengaturan',   fn() => view('admin.pengaturan'))  ->name('admin.pengaturan');
    });