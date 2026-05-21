<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\JadwalModel;
use App\Models\Kelas;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = strtolower(Carbon::now()->locale('id')->dayName); // 'senin', 'selasa', dst

        // ── Stat Cards ───────────────────────────────────────────
        $totalBooking    = Booking::count();
        $totalKelas      = Kelas::count();
        $jadwalHariIni   = JadwalModel::where('hari', $hariIni)
                            ->where('status', 'aktif')->count();
        $bookingHadir    = Booking::where('status', 'hadir')->count();

        // ── Booking Terbaru (5 terakhir) ─────────────────────────
        $bookingTerbaru = Booking::with(['jadwal.kelas'])
                            ->orderBy('kode_booking', 'desc')
                            ->limit(5)
                            ->get();

        // ── Overview Kelas (dari DB, max 6) ──────────────────────
        $kelasList = Kelas::orderBy('nama_kelas')->limit(6)->get()->map(function ($kelas) {
            // Ambil jadwal pertama untuk meta info hari & jam
            $jadwal = JadwalModel::where('kelas_id', $kelas->id_kelas)
                        ->where('status', 'aktif')
                        ->orderBy('hari')->orderBy('jam_mulai')
                        ->first();

            // Jumlah booking untuk kelas ini
            $jumlahBooking = Booking::whereHas('jadwal', fn($q) =>
                $q->where('kelas_id', $kelas->id_kelas)
            )->count();

            return [
                'nama_kelas'    => $kelas->nama_kelas,
                'jadwal_meta'   => $jadwal
                    ? ucfirst($jadwal->hari) . ' · ' . substr($jadwal->jam_mulai, 0, 5) . ' WIB'
                    : 'Belum ada jadwal',
                'jumlah_booking'=> $jumlahBooking,
            ];
        });

        // ── Super Admin: data tambahan ───────────────────────────
        $totalAdmin        = User::whereIn('role', ['admin', 'superadmin'])->count();
        $bookingBulanIni   = Booking::whereRaw('MONTH(kode_booking) = ?', [Carbon::now()->month])
                                ->count();
        // Fallback jika kode_booking tidak punya timestamp: pakai semua booking
        // Ganti dengan kolom tanggal jika tersedia di tabel booking

        return view('admin.dashboard', compact(
            'totalBooking',
            'totalKelas',
            'jadwalHariIni',
            'bookingHadir',
            'bookingTerbaru',
            'kelasList',
            'totalAdmin',
            'bookingBulanIni',
        ));
    }
}