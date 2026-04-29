@extends('layouts.app')

@section('title', 'Beranda - Asha Studio')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
@endsection

@section('content')

    <!-- ========== HERO SECTION ========== -->
    <section id="home" class="hero">
        <div class="hero-left">
            <h1 class="hero-title">Asha Studio</h1>
            <h2 class="hero-subtitle">
                Temukan<br>
                Keseimbangan Tubuh<br>
                dan Pikiran Anda
            </h2>
            <p class="hero-description">
                Bergabunglah dengan komunitas kami untuk merasakan transformasi holistik melalui praktik yoga dan pilates
                yang dipandu oleh instruktur berpengalaman.
            </p>
            <div class="hero-buttons">
                <a href="#schedule" class="btn btn-outline">
                    <i class="fas fa-clock"></i> Lihat Jadwal
                </a>
            </div>
        </div>
        <div class="hero-right">
            <img src="{{ asset('images/home.jpeg') }}" alt="Yoga Studio">
        </div>
    </section>

    <!-- ========== ABOUT SECTION ========== -->
    <section id="about" class="about-section">
        <div class="about-left">
            <img src="{{ asset('images/studio.jpeg') }}" alt="Studio Interior">
        </div>
        <div class="about-right">
            <span class="section-tag">TENTANG KAMI</span>
            <h2 class="about-title">Asha Studio</h2>
            <h3 class="about-subtitle">
                Selamat datang di studio<br>
                Pilates & Yoga kami
            </h3>
            <p class="about-text">
                Kami menyediakan kelas yang dirancang untuk membantu meningkatkan fleksibilitas,
                kekuatan tubuh, serta ketenangan pikiran melalui latihan yang dipandu oleh instruktur profesional.
                Di Asha Studio, kami percaya bahwa kesehatan holistik dimulai dari keseimbangan antara tubuh dan pikiran.
            </p>
            <p class="about-text">
                Dengan fasilitas modern dan lingkungan yang nyaman, kami berkomitmen untuk memberikan pengalaman terbaik
                dalam perjalanan wellness Anda. Bergabunglah dengan kami dan rasakan perbedaannya.
            </p>
            <div class="about-location">
                <i class="fas fa-map-marker-alt"></i>
                <span>Jl. Bonokeling No.1, Demangan, Kec. Taman, Kota Madiun, Jawa Timur 63136</span>
            </div>
        </div>
    </section>

    <!-- ========== CLASS SECTION ========== -->

    {{-- Ambil sampai 4 kelas terbaru dari DB (View::composer menyediakan $kelases) --}}
    @php
        $kelasList = ($kelases ?? collect())->take(4);
    @endphp

    <section id="class" class="class-section">
        <div class="section-header">
            <span class="section-tag">KELAS KAMI</span>
            <h2 class="section-title">Pilih Kelas Favorit Anda</h2>
        </div>
        <div class="class-grid">

            {{-- NANTI BISA DIGANTI DENGAN DATA DARI DATABASE --}}
            {{-- @foreach($kelasList as $kelas) --}}

            @foreach ($kelasList as $kelas)
                @php
                    $gradients = [
                        'linear-gradient(135deg, #667eea, #764ba2)',
                        'linear-gradient(135deg, #ff9a9e, #fad0c4)',
                        'linear-gradient(135deg, #a18cd1, #fbc2eb)',
                        'linear-gradient(135deg, #f6d365, #fda085)'
                    ];
                    $bg = $gradients[$loop->index % count($gradients)];

                    $inisial = strtoupper(substr($kelas->nama, 0, 1));
                @endphp

                <div class="class-card" onclick="openBooking('{{ addslashes($kelas->nama) }}')">

                    {{-- Gradient Banner --}}
                    <div class="class-image" data-bg="{{ $bg }}"
                        style="display:flex; align-items:center; justify-content:center;">
                        <span style="font-size:40px; color:white; font-weight:600;">{{ $inisial }}</span>
                    </div>
                    <div class="class-content">

                        <h3>{{ $kelas->nama }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($kelas->keterangan, 140) }}</p>

                        {{-- Meta info: instruktur --}}
                        <div class="class-meta-row">
                            <span class="class-meta-item"><i class="fas fa-user-tie"></i> {{ $kelas->instruktur }}</span>
                            <span class="class-meta-item"><i class="fas fa-users"></i> Tersedia</span>
                        </div>

                        {{-- Harga --}}
                        <div class="class-price-row">
                            <span class="class-price-label">Harga per sesi</span>
                            <span class="class-price-value">Rp {{ number_format($kelas->harga ?? 0, 0, ',', '.') }}</span>
                        </div>

                        <button class="class-btn class-btn-book" onclick="openBooking('{{ addslashes($kelas->nama) }}')">
                            <i class="fas fa-calendar-plus"></i> Booking Kelas
                        </button>
                    </div>
                </div>
            @endforeach

            {{-- @endforeach --}}
        </div>

        {{-- Tombol lihat semua kelas --}}
        <div style="text-align:center; margin-top: 50px;">
            <a href="{{ route('kelas') }}" class="btn btn-outline">
                <i class="fas fa-th-large"></i> Lihat Semua Kelas
            </a>
        </div>
    </section>

    <!-- ========== SCHEDULE SECTION ========== -->
    <section id="schedule" class="schedule-section">
        <div class="section-header">
            <span class="section-tag">JADWAL KELAS</span>
            <h2 class="section-title">Jadwal Mingguan Kami</h2>
        </div>
        <div class="schedule-container">
            <div class="schedule-table">
                <!-- Header -->
                <div class="schedule-day">SENIN</div>
                <div class="schedule-day">SELASA</div>
                <div class="schedule-day">RABU</div>
                <div class="schedule-day">KAMIS</div>
                <div class="schedule-day">JUMAT</div>
                <div class="schedule-day">SABTU</div>
                <div class="schedule-day">MINGGU</div>

                <!-- Content -->
                {{-- NANTI BAGIAN INI BISA DIGANTI DENGAN DATA DARI DATABASE --}}
                {{-- @foreach($schedules->groupBy('day') as $day => $daySchedules) --}}

                <div class="schedule-content">
                    <div class="schedule-item">10.00 - Vinyasa Flow</div>
                    <div class="schedule-item">16.30 - Hatha Flow</div>

                    {{-- Atau dari database:
                    @foreach($daySchedules as $schedule)
                    <div class="schedule-item">{{ $schedule->time }} - {{ $schedule->class_name }}</div>
                    @endforeach
                    --}}
                </div>

                <div class="schedule-content">
                    <div class="schedule-item">08.00 - Hatha Flow</div>
                </div>

                <div class="schedule-content">
                    <div class="schedule-item">16.30 - Hatha Flow</div>
                    <div class="schedule-item">18.30 - Vinyasa Flow</div>
                </div>

                <div class="schedule-content">
                    <div class="schedule-item">16.30 - Hatha Flow</div>
                </div>

                <div class="schedule-content">
                    <div class="schedule-item">16.30 - Hatha Flow</div>
                    <div class="schedule-item">18.30 - Vinyasa Flow</div>
                </div>

                <div class="schedule-content">
                    <div class="schedule-item">14.30 - Prenatal Yoga Regular</div>
                    <div class="schedule-item">16.30 - Vinyasa Flow</div>
                </div>

                <div class="schedule-content">
                    <div class="schedule-item">08.00 - Prenatal Private Group</div>
                </div>

                {{-- @endforeach --}}
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        // Custom scripts untuk halaman beranda jika diperlukan
        console.log('Beranda loaded successfully!');
    </script>
@endsection