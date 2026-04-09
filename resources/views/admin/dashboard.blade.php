@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, var(--dark) 0%, #7a3a3a 60%, var(--primary) 100%);
        border-radius: 20px;
        padding: 32px 36px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -60px; right: 120px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,0.03);
    }

    .welcome-text h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 30px;
        color: white;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .welcome-text p { font-size: 14px; color: rgba(255,255,255,0.6); }

    .welcome-date { text-align: right; position: relative; z-index: 1; }
    .welcome-date .date-num {
        font-family: 'Cormorant Garamond', serif;
        font-size: 52px;
        color: rgba(255,255,255,0.15);
        line-height: 1;
        font-weight: 700;
    }
    .welcome-date .date-str { font-size: 13px; color: rgba(255,255,255,0.45); }

    /* Stat Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: var(--white);
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        border: 1px solid var(--border);
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        animation: fadeUp 0.5s ease both;
    }

    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.10s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.20s; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(90,46,46,0.12); }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 16px 16px 0 0;
    }

    .stat-card.c1::before { background: var(--primary); }
    .stat-card.c2::before { background: var(--success); }
    .stat-card.c3::before { background: var(--warning); }
    .stat-card.c4::before { background: var(--info); }

    .stat-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        margin-bottom: 16px;
    }

    .stat-card.c1 .stat-icon { background: rgba(166,124,115,0.12); color: var(--primary); }
    .stat-card.c2 .stat-icon { background: rgba(106,158,127,0.12); color: var(--success); }
    .stat-card.c3 .stat-icon { background: rgba(201,169,110,0.12); color: var(--warning); }
    .stat-card.c4 .stat-icon { background: rgba(122,158,181,0.12); color: var(--info); }

    .stat-value {
        font-family: 'Cormorant Garamond', serif;
        font-size: 38px;
        font-weight: 700;
        color: var(--dark);
        line-height: 1;
        margin-bottom: 6px;
    }

    .stat-label { font-size: 13px; color: var(--text-muted); }

    .stat-trend {
        position: absolute;
        top: 24px; right: 24px;
        font-size: 12px;
        font-weight: 600;
        display: flex; align-items: center; gap: 4px;
    }

    .stat-trend.up   { color: var(--success); }
    .stat-trend.down { color: var(--danger); }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 20px;
        margin-bottom: 28px;
    }

    /* Booking Table */
    .booking-table { width: 100%; border-collapse: collapse; }

    .booking-table th {
        padding: 12px 24px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: var(--text-muted);
        letter-spacing: 1px;
        text-transform: uppercase;
        background: var(--light);
        border-bottom: 1px solid var(--border);
    }

    .booking-table td {
        padding: 14px 24px;
        font-size: 13.5px;
        color: var(--dark);
        border-bottom: 1px solid rgba(232,221,216,0.5);
        vertical-align: middle;
    }

    .booking-table tr:last-child td { border-bottom: none; }
    .booking-table tr:hover td { background: rgba(249,245,242,0.7); }

    /* Quick Actions */
    .quick-actions { padding: 20px; display: flex; flex-direction: column; gap: 10px; }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 18px;
        border-radius: 12px;
        border: 1px solid var(--border);
        background: var(--light);
        color: var(--dark);
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 500;
        transition: var(--transition);
    }

    .quick-action-btn:hover {
        background: var(--cream);
        border-color: var(--accent);
        transform: translateX(4px);
    }

    .qa-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    /* Bottom Grid */
    .bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

    .kelas-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 24px;
        border-bottom: 1px solid rgba(232,221,216,0.4);
        transition: var(--transition);
    }

    .kelas-item:last-child { border-bottom: none; }
    .kelas-item:hover { background: var(--light); }
    .kelas-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .kelas-info { flex: 1; }
    .kelas-name { font-size: 13.5px; font-weight: 500; color: var(--dark); }
    .kelas-meta { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
    .kelas-count { font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 700; color: var(--dark); }

    /* Bar Chart */
    .chart-bars {
        padding: 20px 24px;
        display: flex;
        align-items: flex-end;
        gap: 10px;
        height: 160px;
    }

    .bar-group {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        height: 100%;
        justify-content: flex-end;
    }

    .bar-wrap { width: 100%; background: var(--cream); border-radius: 6px 6px 0 0; }

    .bar-fill {
        width: 100%;
        background: linear-gradient(180deg, var(--primary) 0%, var(--accent) 100%);
        border-radius: 6px 6px 0 0;
    }

    .bar-label { font-size: 10px; color: var(--text-muted); font-weight: 500; }

    /* Superadmin Panel */
    .superadmin-panel {
        background: linear-gradient(135deg, #2d1515 0%, #4a2020 100%);
        border-radius: 16px;
        padding: 24px;
        margin-top: 28px;
        border: 1px solid rgba(196,154,154,0.2);
    }

    .superadmin-panel h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 18px;
        color: var(--accent-soft);
        margin-bottom: 16px;
        display: flex; align-items: center; gap: 10px;
    }

    .superadmin-panel h3 i { font-size: 14px; color: var(--accent); }

    .sa-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }

    .sa-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 18px;
        transition: var(--transition);
    }

    .sa-card:hover { background: rgba(255,255,255,0.08); border-color: rgba(196,154,154,0.3); }
    .sa-card .sa-label { font-size: 12px; color: rgba(255,255,255,0.4); margin-bottom: 8px; }
    .sa-card .sa-val   { font-family: 'Cormorant Garamond', serif; font-size: 26px; color: rgba(255,255,255,0.85); font-weight: 600; }
    .sa-card .sa-sub   { font-size: 11px; color: rgba(196,154,154,0.6); margin-top: 4px; }

    @media (max-width: 1100px) {
        .stats-grid   { grid-template-columns: repeat(2, 1fr); }
        .content-grid { grid-template-columns: 1fr; }
        .bottom-grid  { grid-template-columns: 1fr; }
        .sa-grid      { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

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

    {{-- Stat Cards --}}
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
            <span class="stat-trend down"><i class="fas fa-arrow-down"></i> 2%</span>
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Total Member</div>
        </div>
        <div class="stat-card c4">
            <span class="stat-trend up"><i class="fas fa-arrow-up"></i> 8%</span>
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Jadwal Hari Ini</div>
        </div>
    </div>

    {{-- Content Grid --}}
    <div class="content-grid">

        {{-- Booking Terbaru --}}
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

        {{-- Quick Actions --}}
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
                <a href="{{ route('admin.user') }}" class="quick-action-btn">
                    <div class="qa-icon" style="background:rgba(122,158,181,0.12); color:var(--info);">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    Kelola Member
                </a>
                <a href="{{ route('home') }}" class="quick-action-btn" target="_blank">
                    <div class="qa-icon" style="background:rgba(201,169,110,0.12); color:var(--warning);">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                    Lihat Website
                </a>
            </div>
        </div>
    </div>

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

        {{-- Bar Chart --}}
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Booking Mingguan</span>
                <span style="font-size:12px; color:var(--text-muted);">7 hari terakhir</span>
            </div>
            <div class="chart-bars" id="chartBars"></div>
        </div>
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

    (function () {
        const labels = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
        const values = [65, 45, 80, 55, 90, 70, 40];
        const maxVal = Math.max(...values);
        const container = document.getElementById('chartBars');

        labels.forEach((lbl, i) => {
            const pct = (values[i] / maxVal) * 100;
            const group = document.createElement('div');
            group.className = 'bar-group';
            group.innerHTML = `
                <div class="bar-wrap" style="height:${Math.round(pct * 1.1)}px;">
                    <div class="bar-fill" style="height:100%;"></div>
                </div>
                <div class="bar-label">${lbl}</div>
            `;
            container.appendChild(group);
        });
    })();
</script>
@endpush