<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin — Yoga Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-violet-600 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-violet-800">Yoga Studio</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600 hidden sm:block">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-sm bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg transition font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Alert --}}
        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Welcome Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-violet-100 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Selamat datang, {{ Auth::user()->name }}!
                    </h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-gray-500 text-sm">Role kamu:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-violet-100 text-violet-800">
                            Super Admin
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <p class="text-sm text-gray-500 font-medium">Total Booking</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">0</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <p class="text-sm text-gray-500 font-medium">Kelas Aktif</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">0</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <p class="text-sm text-gray-500 font-medium">Member Terdaftar</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">0</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <p class="text-sm text-gray-500 font-medium">Total Admin</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">0</p>
            </div>
        </div>

        {{-- Akses Khusus Super Admin --}}
        <div class="mt-8 bg-violet-50 border border-violet-200 rounded-xl p-6">
            <h2 class="text-base font-semibold text-violet-800 mb-2">⚡ Akses Eksklusif Super Admin</h2>
            <p class="text-sm text-violet-600">
                Kamu memiliki akses penuh ke seluruh fitur sistem, termasuk manajemen admin, konfigurasi sistem, dan laporan lengkap.
            </p>
        </div>

    </main>

</body>
</html>