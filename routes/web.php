<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KelasController;
use App\Models\Booking;
use App\Models\JadwalModel;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Share $jadwals ke semua view publik
|--------------------------------------------------------------------------
*/

View::composer(['beranda', 'kelas', 'layouts.app'], function ($view) {
    // Jadwal aktif dengan relasi kelas (untuk filter per kelas di modal booking)
    $jadwals = JadwalModel::with('kelas')
        ->where('status', 'aktif')
        ->orderBy('hari')
        ->get();

    // Group jadwal berdasarkan kelas_id — dipakai JS untuk filter select jadwal
    // Group by nama_kelas agar JS bisa langsung cocokkan dengan className yang diklik
    $jadwalsByKelas = $jadwals->groupBy(function ($j) {
        return $j->kelas->nama_kelas ?? 'unknown';
    })->map(function ($items) {
        return $items->map(function ($j) {
            $booked = \App\Models\Booking::where('id_jadwal', $j->id_jadwal)->count();
            $kuota  = $j->sisa_kuota ?? null;
            $sisa   = is_null($kuota) ? null : max(0, $kuota - $booked);
            return [
                'id_jadwal' => $j->id_jadwal,
                'label'     => ucfirst($j->hari) . ' — ' . \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') . ' WIB'
                               . (!is_null($kuota) ? ' — Sisa: ' . $sisa : ''),
                'disabled'  => !is_null($sisa) && $sisa <= 0,
            ];
        })->values();
    });

    $view->with('jadwals', $jadwals);
    $view->with('jadwalsByKelas', $jadwalsByKelas);
    // Share kelas untuk halaman publik
    $view->with('kelases', Kelas::orderBy('id_kelas', 'desc')->get()); // ← fix: ganti created_at → id_kelas
});

// ── Halaman Publik ──────────────────────────────────────────
Route::view('/', 'beranda')->name('home');
Route::view('/kelas', 'kelas')->name('kelas');

// ── Booking Publik ──────────────────────────────────────────
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/create', function () {
    return redirect()->route('home');
})->name('booking.create');

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
    });

// ── Super Admin ──────────────────────────────────────────────
Route::prefix('admin')
    ->middleware(['auth', 'role:superadmin'])
    ->group(function () {
        Route::get('/kelola-admin', fn() => view('admin.kelola-admin'))->name('admin.kelola-admin');
        Route::get('/laporan',      fn() => view('admin.laporan'))->name('admin.laporan');
        Route::get('/pengaturan',   fn() => view('admin.pengaturan'))->name('admin.pengaturan');
    });