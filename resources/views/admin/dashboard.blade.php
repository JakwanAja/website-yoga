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
            <h2>Selamat datang, {{ auth()->user()?->nama_user }} 👋</h2>
            <p>Berikut adalah ringkasan aktivitas Asha Studio hari ini.</p>
        </div>
        <div class="welcome-date">
            <div class="date-num" id="dateNum"></div>
            <div class="date-str" id="dateStr"></div>
        </div>
    </div>

    {{-- Content Grid: Booking Terbaru + Quick Actions --}}
    <div class="content-grid">
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Booking Terbaru</span>
                <a href="{{ route('admin.booking') }}" class="panel-action">Lihat semua →</a>
            </div>
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookingTerbaru as $b)
                        <tr>
                            <td style="color:var(--text-muted); font-size:12px;">{{ $b->kode_booking }}</td>
                            <td>{{ $b->nama }}</td>
                            <td>{{ $b->jadwal?->kelas?->nama_kelas ?? '—' }}</td>
                            <td style="font-size:12px; color:var(--text-muted);">
                                {{ $b->jadwal ? ucfirst($b->jadwal->hari) . ', ' . substr($b->jadwal->jam_mulai, 0, 5) . ' WIB' : '—' }}
                            </td>
                            <td>
                                @php $info = $b->status_info; @endphp
                                <span class="status-badge {{ $info['class'] }}">{{ $info['label'] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color:var(--text-muted); font-size:13px; padding:32px;">
                                <i class="fas fa-inbox" style="font-size:24px; margin-bottom:10px; display:block; opacity:0.3;"></i>
                                Belum ada data booking
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Quick Actions --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Quick Actions</span>
            </div>
            <div class="quick-actions">
                <a href="{{ route('admin.booking') }}" class="quick-action-btn">
                    <div class="qa-icon" style="background:rgba(166,124,115,0.12); color:var(--primary);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    Kelola Booking
                </a>
                <a href="{{ route('admin.jadwal.create') }}" class="quick-action-btn">
                    <div class="qa-icon" style="background:rgba(106,158,127,0.12); color:var(--success);">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    Tambah Jadwal
                </a>
                <a href="{{ route('admin.kelas.create') }}" class="quick-action-btn">
                    <div class="qa-icon" style="background:rgba(201,169,110,0.12); color:var(--warning);">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    Tambah Kelas
                </a>
                <a href="{{ route('home') }}" class="quick-action-btn" target="_blank">
                    <div class="qa-icon" style="background:rgba(122,158,181,0.12); color:var(--info);">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                    Lihat Website
                </a>
            </div>
        </div>
    </div>

    {{-- Bottom Grid --}}
    <div class="bottom-grid">

        {{-- Overview Kelas dari DB --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Overview Kelas</span>
                <a href="{{ route('admin.kelas') }}" class="panel-action">Kelola →</a>
            </div>
            <div>
                @php
                    $dotColors = ['#a67c73','#6a9e7f','#c9a96e','#7a9eb5','#9b7fc4','#e08a8a'];
                @endphp

                @forelse($kelasList as $i => $k)
                    <div class="kelas-item">
                        <div class="kelas-dot" style="background:{{ $dotColors[$i % count($dotColors)] }};"></div>
                        <div class="kelas-info">
                            <div class="kelas-name">{{ $k['nama_kelas'] }}</div>
                            <div class="kelas-meta">{{ $k['jadwal_meta'] }}</div>
                        </div>
                        <div class="kelas-count" title="Total booking">{{ $k['jumlah_booking'] }}</div>
                    </div>
                @empty
                    <div style="padding:32px; text-align:center; color:var(--text-muted); font-size:13px;">
                        <i class="fas fa-layer-group" style="font-size:24px; display:block; margin-bottom:10px; opacity:0.3;"></i>
                        Belum ada kelas
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Super Admin Panel --}}
        @if(auth()->user()?->role === 'superadmin')
        <div class="superadmin-panel" style="margin-top: 0;">
            <h3>
                <i class="fas fa-crown"></i>
                Panel Super Admin
            </h3>
            <div class="sa-grid">
                <a href="{{ route('admin.manage-admin') }}" class="sa-card" style="text-decoration:none;">
                    <div class="sa-label">Akun Admin</div>
                    <div class="sa-val">{{ $totalAdmin }}</div>
                    <div class="sa-sub">Total admin terdaftar</div>
                    <div style="margin-top:14px; font-size:12px; color:rgba(196,154,154,0.7);">
                        <i class="fas fa-user-shield" style="margin-right:6px;"></i>Kelola Akun Admin →
                    </div>
                </a>
                <a href="{{ route('admin.booking') }}" class="sa-card" style="text-decoration:none;">
                    <div class="sa-label">Seluruh Booking</div>
                    <div class="sa-val">{{ $totalBooking }}</div>
                    <div class="sa-sub">Total booking semua waktu</div>
                    <div style="margin-top:14px; font-size:12px; color:rgba(196,154,154,0.7);">
                        <i class="fas fa-calendar-check" style="margin-right:6px;"></i>Lihat Semua Data →
                    </div>
                </a>
                <a href="{{ route('admin.laporan') }}" class="sa-card" style="text-decoration:none;">
                    <div class="sa-label">Laporan Booking</div>
                    <div class="sa-val">{{ $bookingBulanIni }}</div>
                    <div class="sa-sub">Booking tercatat</div>
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