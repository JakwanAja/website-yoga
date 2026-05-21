<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard') — Asha Studio Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600&family=Lavishly+Yours&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @yield('styles')

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
            </a>
            <a href="{{ route('admin.kelas') }}"
               class="nav-item {{ request()->routeIs('admin.kelas*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> Kelas
            </a>
            <a href="{{ route('admin.jadwal') }}"
               class="nav-item {{ request()->routeIs('admin.jadwal*') ? 'active' : '' }}">
                <i class="fas fa-clock"></i> Jadwal
            </a>
            <a href="{{ route('admin.pengaturan') }}"
               class="nav-item {{ request()->routeIs('admin.pengaturan*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Pengaturan
            </a>

            {{-- Menu khusus Super Admin --}}
            @if(auth()->user()?->role === 'superadmin')
            <div class="nav-section-label">Super Admin</div>
            <a href="{{ route('admin.manage-admin') }}"
               class="nav-item {{ request()->routeIs('admin.manage-admin') || request()->routeIs('admin.admin.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i> Kelola Admin
            </a>
            <a href="{{ route('admin.laporan') }}"
               class="nav-item {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()?->nama_user ?? 'A', 0, 1)) }}
                </div>
                <div class="user-meta">
                    <div class="user-name">{{ auth()->user()?->nama_user }}</div>
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

    <div class="main">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <div class="breadcrumb">
                    Asha Studio &rsaquo; Admin &rsaquo; @yield('page-title', 'Dashboard')
                </div>
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
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>

    @stack('scripts')

</body>
</html>