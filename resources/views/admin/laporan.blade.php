@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')

{{-- ══ FILTER BAR ══════════════════════════════════════════════════ --}}
<form method="GET" action="{{ route('admin.laporan') }}">
    <div class="filter-bar">
        <div class="filter-group">
            <label><i class="fas fa-calendar-alt"></i> Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" value="{{ $tanggalMulai }}">
        </div>
        <div class="filter-group">
            <label><i class="fas fa-calendar-alt"></i> Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
        </div>
        <button type="submit" class="btn-filter">
            <i class="fas fa-filter"></i> Terapkan Filter
        </button>
        <a href="javascript:window.print()" class="btn-print">
            <i class="fas fa-print"></i> Cetak
        </a>

        @if(!$hasDateColumn)
            <div class="no-date-notice">
                <i class="fas fa-info-circle"></i>
                Filter periode dinonaktifkan — kolom <code>tanggal_booking</code> belum ada di tabel.
            </div>
        @endif
    </div>
</form>

{{-- ══ STAT CARDS ══════════════════════════════════════════════════ --}}
<div class="stat-grid">
    <div class="stat-card accent-gold">
        <div class="stat-icon gold"><i class="fas fa-ticket-alt"></i></div>
        <div class="stat-value">{{ $totalBooking }}</div>
        <div class="stat-label">Total Booking</div>
    </div>
    <div class="stat-card accent-blue">
        <div class="stat-icon blue"><i class="fas fa-check-double"></i></div>
        <div class="stat-value">{{ $totalTerkonfirmasi }}</div>
        <div class="stat-label">Terkonfirmasi</div>
    </div>
    <div class="stat-card accent-green">
        <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
        <div class="stat-value">{{ $totalHadir }}</div>
        <div class="stat-label">Hadir</div>
    </div>
    <div class="stat-card accent-purple">
        <div class="stat-icon purple"><i class="fas fa-flag-checkered"></i></div>
        <div class="stat-value">{{ $totalSelesai }}</div>
        <div class="stat-label">Selesai</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal"><i class="fas fa-calendar-check"></i></div>
        <div class="stat-value">{{ $totalJadwalAktif }}</div>
        <div class="stat-label">Jadwal Aktif</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-layer-group"></i></div>
        <div class="stat-value">{{ $totalKelas }}</div>
        <div class="stat-label">Total Kelas</div>
    </div>
</div>

{{-- ══ ESTIMASI PENDAPATAN HERO ══════════════════════════════════════ --}}
<div class="revenue-hero">
    <div>
        <div class="revenue-hero-label"><i class="fas fa-coins"></i>&nbsp; Estimasi Pendapatan</div>
        <div class="revenue-hero-value">
            Rp {{ number_format($estimasiPendapatan, 0, ',', '.') }}
        </div>
        <div class="revenue-hero-sub">
            Dihitung dari {{ $allBookings->whereIn('status', ['hadir','selesai'])->count() }} booking
            berstatus <em>Hadir</em> &amp; <em>Selesai</em>
            @if($hasDateColumn)
                &nbsp;|&nbsp; Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d M Y') }}
                – {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}
            @endif
        </div>
    </div>
    <div class="revenue-hero-icon"><i class="fas fa-money-bill-trend-up"></i></div>
</div>

{{-- ══ SECTION GRID ════════════════════════════════════════════════ --}}
<div class="section-grid">

    {{-- Kelas Populer --}}
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-fire"></i> Kelas Terpopuler</h3>
        </div>
        <div class="panel-body">
            @php $maxBooking = $kelasPoluler->max('total_booking') ?: 1; @endphp
            @forelse($kelasPoluler as $i => $item)
                @php $kelas = $item['kelas']; @endphp
                <div class="kelas-item">
                    <div class="kelas-rank rank-{{ $i + 1 }}">{{ $i + 1 }}</div>
                    <div class="kelas-info">
                        <div class="kelas-name">{{ $kelas->nama_kelas ?? '-' }}</div>
                        <div class="kelas-sub">
                            {{ $item['total_hadir'] }} hadir &middot;
                            {{ $kelas ? 'Rp ' . number_format($kelas->biaya, 0, ',', '.') : '-' }}
                        </div>
                        <div class="kelas-bar-wrap">
                            <div class="kelas-bar" style="width: {{ round(($item['total_booking'] / $maxBooking) * 100) }}%"></div>
                        </div>
                    </div>
                    <div class="kelas-count">{{ $item['total_booking'] }}</div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada data booking.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Distribusi Status --}}
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-chart-pie"></i> Distribusi Status</h3>
        </div>
        <div class="panel-body">
            <div class="status-dist-list">
                @foreach($distribusiStatus as $item)
                    @php
                        $pct = $totalBooking > 0 ? round(($item['jumlah'] / $totalBooking) * 100) : 0;
                    @endphp
                    <div class="status-dist-item">
                        <div class="status-dot {{ $item['class'] }}"></div>
                        <div class="status-dist-label">{{ $item['status'] }}</div>
                        <div class="status-progress">
                            <div class="status-progress-bar {{ $item['class'] }}" style="width: {{ $pct }}%"></div>
                        </div>
                        <div class="status-dist-count">{{ $item['jumlah'] }}</div>
                        <div class="status-dist-pct">{{ $pct }}%</div>
                    </div>
                @endforeach

                @if($totalBooking === 0)
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada data booking.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Tabel Pendapatan Per Kelas --}}
    <div class="panel panel-full">
        <div class="panel-header">
            <h3><i class="fas fa-table"></i> Rincian Pendapatan per Kelas</h3>
        </div>
        <div class="panel-body" style="padding: 0;">
            @if($pendapatanPerKelas->isNotEmpty())
            <table class="laporan-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelas</th>
                        <th>Jumlah Hadir/Selesai</th>
                        <th>Estimasi Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendapatanPerKelas as $i => $row)
                    <tr>
                        <td style="color: var(--slate); width: 40px;">{{ $i + 1 }}</td>
                        <td><strong>{{ $row['nama_kelas'] }}</strong></td>
                        <td>{{ $row['jumlah'] }} booking</td>
                        <td class="td-rp">Rp {{ number_format($row['pendapatan'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><strong>Total Keseluruhan</strong></td>
                        <td><strong>{{ $allBookings->whereIn('status', ['hadir','selesai'])->count() }} booking</strong></td>
                        <td class="td-rp"><strong>Rp {{ number_format($estimasiPendapatan, 0, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada booking berstatus <em>hadir</em> atau <em>selesai</em>.</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    // Animasi bar masuk setelah halaman load
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.kelas-bar, .status-progress-bar').forEach(bar => {
            const w = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => { bar.style.width = w; }, 200);
        });
    });
</script>
@endpush