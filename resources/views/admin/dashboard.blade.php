@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')

    {{-- Welcome Banner --}}
    <div class="welcome-banner">
        <div class="welcome-text">
            <h2>Selamat datang 👋</h2>
            <p>Berikut adalah ringkasan aktivitas Asha Studio hari ini.</p>
        </div>
        <div class="welcome-date">
            <div class="date-num" id="dateNum"></div>
            <div class="date-str" id="dateStr"></div>
        </div>
    </div>

    {{-- Stat Cards 
    <div class="stats-grid">
        <div class="stat-card c1">
            <span class="stat-trend up"><i class="fas fa-arrow-up"></i> 12%</span>
            <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Total Booking</div>
        </div>
        <div class="stat-card c2">
            <span class="stat-trend up"><i class="fas fa-arrow-up"></i> 5%</span>
            <div class="stat-icon"><i class="fas fa-dumbbell"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Kelas Aktif</div>
        </div>
        <div class="stat-card c3">
            <span class="stat-trend up"><i class="fas fa-arrow-up"></i> 4%</span>
            <div class="stat-icon"><i class="fas fa-user-check"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Terverifikasi Hari Ini</div>
        </div>
        <div class="stat-card c4">
            <span class="stat-trend up"><i class="fas fa-arrow-up"></i> 8%</span>
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Jadwal Hari Ini</div>
        </div>
    </div> --}}

    {{-- Content Grid --}}
    {{--  <div class="content-grid">
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Booking Terbaru</span>
                <a href="{{ route('admin.booking') }}" class="panel-action">Lihat semua →</a>
            </div>
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" style="text-align:center; color:var(--text-muted); font-size:13px; padding:32px;">
                            <i class="fas fa-database" style="font-size:24px; margin-bottom:10px; display:block; opacity:0.3;"></i>
                            Hubungkan dengan database untuk menampilkan data
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Quick Actions
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Quick Actions</span>
            </div>
            <div class="quick-actions">
                <a href="{{ route('admin.booking') }}" class="quick-action-btn">
                    <div class="qa-icon" style="background:rgba(166,124,115,0.12); color:var(--primary);">
                        <i class="fas fa-plus"></i>
                    </div>
                    Tambah Booking Baru
                </a>
                <a href="{{ route('admin.jadwal') }}" class="quick-action-btn">
                    <div class="qa-icon" style="background:rgba(106,158,127,0.12); color:var(--success);">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    Atur Jadwal Kelas
                </a>
                <a href="{{ route('home') }}" class="quick-action-btn" target="_blank">
                    <div class="qa-icon" style="background:rgba(201,169,110,0.12); color:var(--warning);">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                    Lihat Website
                </a>
            </div>
        </div>
    </div>  --}}

    {{-- Bottom Grid --}}
    <div class="bottom-grid">

        {{-- Kelas Overview --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Overview Kelas</span>
            </div>
            <div>
                <div class="kelas-item">
                    <div class="kelas-dot" style="background:#a67c73;"></div>
                    <div class="kelas-info">
                        <div class="kelas-name">Beginner Yoga</div>
                        <div class="kelas-meta">Senin & Jumat · 08.00 WIB</div>
                    </div>
                    <div class="kelas-count">—</div>
                </div>
                <div class="kelas-item">
                    <div class="kelas-dot" style="background:#6a9e7f;"></div>
                    <div class="kelas-info">
                        <div class="kelas-name">Pilates Core</div>
                        <div class="kelas-meta">Rabu · 10.00 WIB</div>
                    </div>
                    <div class="kelas-count">—</div>
                </div>
                <div class="kelas-item">
                    <div class="kelas-dot" style="background:#c9a96e;"></div>
                    <div class="kelas-info">
                        <div class="kelas-name">Yoga Relax</div>
                        <div class="kelas-meta">Jumat · 16.00 WIB</div>
                    </div>
                    <div class="kelas-count">—</div>
                </div>
                <div class="kelas-item">
                    <div class="kelas-dot" style="background:#7a9eb5;"></div>
                    <div class="kelas-info">
                        <div class="kelas-name">Private Session</div>
                        <div class="kelas-meta">Minggu · 10.00 WIB</div>
                    </div>
                    <div class="kelas-count">—</div>
                </div>
            </div>
        </div>

        {{-- Super Admin Panel — hanya tampil untuk superadmin --}}
        @if(auth()->user()?->role === 'superadmin')
        <div class="superadmin-panel" style="margin-top: 28px;">
            <h3>
                <i class="fas fa-crown"></i>
                Panel Super Admin
            </h3>
            <div class="sa-grid">
                <a href="#" class="sa-card" style="text-decoration:none;">
                    <div class="sa-label">Akun Admin</div>
                    <div class="sa-val">—</div>
                    <div class="sa-sub">Total admin terdaftar</div>
                    <div style="margin-top:14px; font-size:12px; color:rgba(196,154,154,0.7);">
                        <i class="fas fa-user-shield" style="margin-right:6px;"></i>Kelola Akun Admin →
                    </div>
                </a>
                <a href="{{ route('admin.booking') }}" class="sa-card" style="text-decoration:none;">
                    <div class="sa-label">Seluruh Booking</div>
                    <div class="sa-val">—</div>
                    <div class="sa-sub">Total booking semua waktu</div>
                    <div style="margin-top:14px; font-size:12px; color:rgba(196,154,154,0.7);">
                        <i class="fas fa-calendar-check" style="margin-right:6px;"></i>Lihat Semua Data →
                    </div>
                </a>
                <a href="#" class="sa-card" style="text-decoration:none;">
                    <div class="sa-label">Laporan Booking</div>
                    <div class="sa-val">—</div>
                    <div class="sa-sub">Booking bulan ini</div>
                    <div style="margin-top:14px; font-size:12px; color:rgba(196,154,154,0.7);">
                        <i class="fas fa-chart-line" style="margin-right:6px;"></i>Lihat Laporan →
                    </div>
                </a>
            </div>
        </div>
        @endif

    </div>

@endsection

@push('scripts')
<script>
    // Live date
    (function () {
        const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Januari','Februari','Maret','April','Mei','Juni',
                        'Juli','Agustus','September','Oktober','November','Desember'];
        const now = new Date();
        document.getElementById('dateNum').textContent = String(now.getDate()).padStart(2, '0');
        document.getElementById('dateStr').textContent =
            days[now.getDay()] + ', ' + months[now.getMonth()] + ' ' + now.getFullYear();
    })();
</script>
@endpush