<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\JadwalModel;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // ── Default periode: bulan ini ────────────────────────────────
        $tanggalMulai = $request->input('tanggal_mulai', now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', now()->toDateString());

        // ── Query booking dalam rentang tanggal ──────────────────────
        // Tabel booking tidak punya timestamps, jadi kita pakai kode_booking
        // sebagai proxy; jika Anda ingin filter by tanggal, tambahkan kolom
        // tanggal_booking ke tabel booking.
        // Untuk saat ini, jika kolom tanggal_booking ADA, dipakai. Jika tidak,
        // semua booking ditampilkan (dan filter periode diabaikan untuk booking).
        $hasDateColumn = Schema::hasColumn('booking', 'tanggal_booking');

        $bookingQuery = Booking::with(['jadwal.kelas']);

        if ($hasDateColumn) {
            $bookingQuery->whereBetween('tanggal_booking', [$tanggalMulai, $tanggalAkhir]);
        }

        $allBookings = $bookingQuery->get();

        // ── Statistik Booking ─────────────────────────────────────────
        $totalBooking      = $allBookings->count();
        $totalTerkonfirmasi = $allBookings->where('status', 'terkonfirmasi')->count();
        $totalHadir        = $allBookings->where('status', 'hadir')->count();
        $totalSelesai      = $allBookings->where('status', 'selesai')->count();
        $totalBatal        = $allBookings->whereNotIn('status', ['booking', 'terkonfirmasi', 'hadir', 'selesai'])->count();

        // ── Kelas Populer (berdasarkan jumlah booking) ────────────────
        $kelasPoluler = $allBookings
            ->groupBy(fn($b) => optional(optional($b->jadwal)->kelas)->id_kelas)
            ->filter(fn($group, $key) => $key !== null)
            ->map(fn($group) => [
                'kelas'         => optional(optional($group->first()->jadwal)->kelas),
                'total_booking' => $group->count(),
                'total_hadir'   => $group->whereIn('status', ['hadir', 'selesai'])->count(),
            ])
            ->sortByDesc('total_booking')
            ->values()
            ->take(5);

        // ── Estimasi Pendapatan ───────────────────────────────────────
        // Hitung dari booking dengan status 'hadir' atau 'selesai'
        $estimasiPendapatan = $allBookings
            ->whereIn('status', ['hadir', 'selesai'])
            ->sum(fn($b) => optional(optional($b->jadwal)->kelas)->biaya ?? 0);

        // Pendapatan per kelas
        $pendapatanPerKelas = $allBookings
            ->whereIn('status', ['hadir', 'selesai'])
            ->groupBy(fn($b) => optional(optional($b->jadwal)->kelas)->id_kelas)
            ->filter(fn($group, $key) => $key !== null)
            ->map(fn($group) => [
                'nama_kelas' => optional(optional($group->first()->jadwal)->kelas)->nama_kelas ?? '-',
                'jumlah'     => $group->count(),
                'pendapatan' => $group->sum(fn($b) => optional(optional($b->jadwal)->kelas)->biaya ?? 0),
            ])
            ->sortByDesc('pendapatan')
            ->values();

        // ── Distribusi Status ─────────────────────────────────────────
        $distribusiStatus = [
            ['status' => 'Booking',       'jumlah' => $allBookings->where('status', 'booking')->count(),       'class' => 'status-booking'],
            ['status' => 'Terkonfirmasi', 'jumlah' => $allBookings->where('status', 'terkonfirmasi')->count(), 'class' => 'status-terkonfirmasi'],
            ['status' => 'Hadir',         'jumlah' => $allBookings->where('status', 'hadir')->count(),         'class' => 'status-hadir'],
            ['status' => 'Selesai',       'jumlah' => $allBookings->where('status', 'selesai')->count(),       'class' => 'status-selesai'],
        ];

        // ── Data jadwal aktif ─────────────────────────────────────────
        $totalJadwalAktif = JadwalModel::where('status', 'aktif')->count();
        $totalKelas       = Kelas::count();

        return view('admin.laporan', compact(
            'tanggalMulai',
            'tanggalAkhir',
            'totalBooking',
            'totalTerkonfirmasi',
            'totalHadir',
            'totalSelesai',
            'kelasPoluler',
            'estimasiPendapatan',
            'pendapatanPerKelas',
            'distribusiStatus',
            'totalJadwalAktif',
            'totalKelas',
            'hasDateColumn',
            'allBookings',
        ));
    }
}