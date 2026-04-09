<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard') — Asha Studio Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600&family=Lavishly+Yours&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary:      #a67c73;
            --primary-dark: #8a6059;
            --dark:         #5a2e2e;
            --light:        #f9f5f2;
            --cream:        #f2ebe3;
            --accent:       #c49a9a;
            --accent-soft:  #e8dccf;
            --sidebar-bg:   #3d1f1f;
            --sidebar-w:    260px;
            --text-muted:   #9a8880;
            --border:       #e8ddd8;
            --white:        #ffffff;
            --success:      #6a9e7f;
            --warning:      #c9a96e;
            --danger:       #b85c5c;
            --info:         #7a9eb5;
            --card-shadow:  0 2px 20px rgba(90,46,46,0.08);
            --transition:   all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--light);
            color: var(--dark);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ══════════════════════════════
           SIDEBAR
        ══════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: var(--transition);
        }

        .sidebar-brand {
            padding: 32px 28px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .sidebar-brand .brand-logo {
            width: 48px; height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent);
            margin-bottom: 12px;
            display: block;
        }

        .sidebar-brand .brand-name {
            font-family: 'Lavishly Yours', cursive;
            font-size: 26px;
            color: var(--accent-soft);
            line-height: 1;
        }

        .sidebar-brand .brand-sub {
            font-size: 11px;
            color: rgba(255,255,255,0.35);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            padding: 16px 28px 8px;
            font-weight: 600;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 28px;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }

        .nav-item i {
            width: 18px;
            font-size: 15px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-item:hover {
            color: rgba(255,255,255,0.9);
            background: rgba(255,255,255,0.05);
            border-left-color: var(--accent);
        }

        .nav-item.active {
            color: var(--accent-soft);
            background: rgba(196,154,154,0.12);
            border-left-color: var(--accent);
            font-weight: 500;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--primary);
            color: white;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 20px 28px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .user-avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            color: white;
            font-weight: 600;
            flex-shrink: 0;
        }

        .user-meta .user-name {
            font-size: 13px;
            color: rgba(255,255,255,0.85);
            font-weight: 500;
        }

        .user-meta .user-role {
            font-size: 11px;
            color: var(--accent);
            text-transform: capitalize;
        }

        .logout-btn {
            width: 100%;
            padding: 10px;
            background: rgba(184,92,92,0.15);
            color: #e08080;
            border: 1px solid rgba(184,92,92,0.2);
            border-radius: 10px;
            cursor: pointer;
            font-size: 13px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            transition: var(--transition);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        .logout-btn:hover {
            background: rgba(184,92,92,0.3);
            border-color: rgba(184,92,92,0.4);
            color: #f0a0a0;
        }

        /* ══════════════════════════════
           MAIN
        ══════════════════════════════ */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ══════════════════════════════
           TOPBAR
        ══════════════════════════════ */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 0 36px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
        }

        .topbar-left .breadcrumb {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            transition: var(--transition);
            position: relative;
        }

        .topbar-btn:hover { background: var(--cream); color: var(--dark); }

        .notif-dot {
            position: absolute;
            top: 6px; right: 6px;
            width: 7px; height: 7px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid white;
        }

        .topbar-role-badge {
            background: var(--accent-soft);
            color: var(--dark);
            font-size: 12px;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 20px;
            text-transform: capitalize;
        }

        /* ══════════════════════════════
           PAGE BODY
        ══════════════════════════════ */
        .page-body {
            padding: 32px 36px;
            flex: 1;
        }

        /* Alert */
        .alert-success {
            background: #f0faf4;
            border: 1px solid #a8d5b5;
            color: #2d6a4f;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 28px;
            font-size: 14px;
            display: flex; align-items: center; gap: 10px;
            animation: slideDown 0.4s ease;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #b91c1c;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 28px;
            font-size: 14px;
            display: flex; align-items: center; gap: 10px;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ══════════════════════════════
           SHARED COMPONENT STYLES
           (dipakai oleh semua halaman admin)
        ══════════════════════════════ */
        .panel {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .panel-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .panel-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
        }

        .panel-action {
            font-size: 12px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .panel-action:hover { color: var(--dark); }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 13.5px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-primary:hover { background: var(--primary-dark); }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-badge::before {
            content: '';
            width: 5px; height: 5px;
            border-radius: 50%;
        }

        .status-badge.confirmed { background: rgba(106,158,127,0.12); color: var(--success); }
        .status-badge.confirmed::before { background: var(--success); }
        .status-badge.pending   { background: rgba(201,169,110,0.12); color: var(--warning); }
        .status-badge.pending::before   { background: var(--warning); }
        .status-badge.cancelled { background: rgba(184,92,92,0.12);  color: var(--danger);  }
        .status-badge.cancelled::before { background: var(--danger); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--accent-soft); border-radius: 10px; }

        /* Responsive */
        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            .sidebar { transform: translateX(-260px); }
            .sidebar.open { transform: translateX(0); width: 260px; }
            .main { margin-left: 0; }
            .page-body { padding: 20px; }
            .topbar { padding: 0 20px; }
        }

        @yield('styles')
    </style>

    @stack('styles')
</head>
<body>

    <!-- ══════════════════════════════
         SIDEBAR
    ══════════════════════════════ -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="brand-logo">
            <div class="brand-name">Asha Studio</div>
            <div class="brand-sub">Admin Panel</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Main</div>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            <div class="nav-section-label">Manajemen</div>
            <a href="{{ route('admin.booking') }}"
               class="nav-item {{ request()->routeIs('admin.booking') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> Booking
                {{-- <span class="nav-badge">3</span> --}}
            </a>
            <a href="{{ route('admin.jadwal') }}"
               class="nav-item {{ request()->routeIs('admin.jadwal') ? 'active' : '' }}">
                <i class="fas fa-clock"></i> Jadwal
            </a>
            <a href="{{ route('admin.user') }}"
               class="nav-item {{ request()->routeIs('admin.user') ? 'active' : '' }}">
                <i class="fas fa-users"></i> User
            </a>

            @if(auth()->user()?->role === 'superadmin')
            <div class="nav-section-label">Super Admin</div>
            <a href="#" class="nav-item {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
            <a href="#" class="nav-item {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Pengaturan
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()?->name, 0, 1)) }}
                </div>
                <div class="user-meta">
                    <div class="user-name">{{ auth()->user()?->name }}</div>
                    <div class="user-role">{{ auth()->user()?->role }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- ══════════════════════════════
         MAIN
    ══════════════════════════════ -->
    <div class="main">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <div class="breadcrumb">
                    Asha Studio &rsaquo; Admin &rsaquo; @yield('page-title', 'Dashboard')
                </div>
            </div>
            <div class="topbar-right">
                <button class="topbar-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notif-dot"></span>
                </button>
                <button class="topbar-btn">
                    <i class="fas fa-search"></i>
                </button>
                <span class="topbar-role-badge">
                    <i class="fas fa-shield-alt" style="font-size:10px; margin-right:4px;"></i>
                    {{ ucfirst(auth()->user()?->role) }}
                </span>
            </div>
        </header>

        <!-- PAGE BODY -->
        <div class="page-body">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            {{-- Konten halaman masing-masing --}}
            @yield('content')

        </div>
    </div>

    <script>
        // Auto-aktif sidebar item via route (sudah pakai routeIs di blade)
        // Responsive sidebar toggle (untuk mobile)
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>

    @stack('scripts')

</body>
</html>