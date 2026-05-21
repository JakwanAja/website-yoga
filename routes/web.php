<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Models\JadwalModel; 
use App\Models\Kelas;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Share $jadwals & $jadwalsByKelas ke semua view publik
|--------------------------------------------------------------------------
*/

View::composer(['beranda', 'kelas', 'layouts.app'], function ($view) {

    // FIX 1: Pakai JadwalModel (bukan JadwalKelas) & filter status 'aktif' (bukan integer 1)
    $jadwals = JadwalModel::with('kelas')
        ->where('status', 'aktif')
        ->orderBy('hari')
        ->orderBy('jam_mulai')
        ->get();

    // FIX 2: Buat $jadwalsByKelas yang dibutuhkan JS di app.blade.php untuk dropdown modal booking
    $jadwalsByKelas = $jadwals
        ->groupBy(fn($j) => $j->kelas->nama_kelas ?? 'Lainnya')
        ->map(fn($group) => $group->map(fn($j) => [
            'id_jadwal' => $j->id_jadwal,
            'label'     => ucfirst($j->hari) . ' - ' . substr($j->jam_mulai, 0, 5) . ' WIB',
            'disabled'  => ($j->sisa_kuota !== null && $j->sisa_kuota <= 0),
        ])->values())
        ->toArray();

    $view->with('jadwals', $jadwals);
    $view->with('jadwalsByKelas', $jadwalsByKelas); // FIX 3: variable ini yang hilang, dipakai JS di app.blade.php
    $view->with('kelases', Kelas::orderBy('id_kelas', 'desc')->get());
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

        // Jadwal CRUD
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('admin.jadwal');
        Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('admin.jadwal.create');
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('admin.jadwal.store');
        Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('admin.jadwal.edit');
        Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('admin.jadwal.update');
        Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('admin.jadwal.destroy');

        // Kelas CRUD
        Route::get('/kelas', [KelasController::class, 'index'])->name('admin.kelas');
        Route::get('/kelas/create', [KelasController::class, 'create'])->name('admin.kelas.create');
        Route::post('/kelas', [KelasController::class, 'store'])->name('admin.kelas.store');
        Route::get('/kelas/{id}/edit', [KelasController::class, 'edit'])->name('admin.kelas.edit');
        Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
        Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');

        // Booking CRUD
        Route::get('/booking',                   [BookingController::class, 'index'])->name('admin.booking');
        Route::get('/booking/{id}/edit',         [BookingController::class, 'edit'])->name('admin.booking.edit');
        Route::put('/booking/{id}',              [BookingController::class, 'update'])->name('admin.booking.update');
        Route::patch('/booking/{id}/status',     [BookingController::class, 'updateStatus'])->name('admin.booking.status');
        Route::delete('/booking/{id}',           [BookingController::class, 'destroy'])->name('admin.booking.destroy');

        // Pengaturan Akun — bisa diakses admin & superadmin
        Route::get('/pengaturan',              [PengaturanController::class, 'index'])->name('admin.pengaturan');
        Route::put('/pengaturan/profil',       [PengaturanController::class, 'updateProfil'])->name('admin.pengaturan.profil');
        Route::put('/pengaturan/password',     [PengaturanController::class, 'updatePassword'])->name('admin.pengaturan.password');
    });

// ── Super Admin ──────────────────────────────────────────────
Route::prefix('admin')
    ->middleware(['auth', 'role:superadmin'])
    ->group(function () {
        Route::get('/kelola-admin-page', fn() => view('admin.kelola-admin'))->name('admin.kelola-admin');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');

        // Manage Admin CRUD
        Route::get('/manage-admin',              [ManageAdminController::class, 'index'])->name('admin.manage-admin');
        Route::get('/manage-admin/create',       [ManageAdminController::class, 'create'])->name('admin.admin.create');
        Route::post('/manage-admin',             [ManageAdminController::class, 'store'])->name('admin.admin.store');
        Route::get('/manage-admin/{id}/edit',    [ManageAdminController::class, 'edit'])->name('admin.admin.edit');
        Route::put('/manage-admin/{id}',         [ManageAdminController::class, 'update'])->name('admin.admin.update');
        Route::delete('/manage-admin/{id}',      [ManageAdminController::class, 'destroy'])->name('admin.admin.destroy');
    });