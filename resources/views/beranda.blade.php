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
            Bergabunglah dengan komunitas kami untuk merasakan transformasi holistik melalui praktik yoga dan pilates yang dipandu oleh instruktur berpengalaman.
        </p>
        <div class="hero-buttons">
            <button class="btn btn-primary" onclick="openBooking('General Class')">
                <i class="fas fa-calendar-check"></i> Booking Sekarang
            </button>
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
            <span>Surakarta, Jawa Tengah</span>
        </div>
    </div>
</section>

<!-- ========== CLASS SECTION ========== -->

{{-- ===== DATA DUMMY KELAS (sinkron dengan kelas.blade.php) ===== --}}
@php
$kelasList = [
    [
        'id'             => 1,
        'nama_kelas'     => 'Beginner Yoga',
        'deskripsi'      => 'Kelas yoga dasar yang dirancang khusus untuk pemula. Kamu akan belajar teknik pernapasan, gerakan dasar asana, dan melatih keseimbangan tubuh secara perlahan dan menyenangkan.',
        'instruktur'     => 'Sari Dewi, S.Pd.',
        'kuota_maksimal' => 12,
        'kuota_sisa'     => 4,
        'harga'          => 150000,
        'kategori'       => 'yoga',
        'banner_class'   => 'yoga',
    ],
    [
        'id'             => 2,
        'nama_kelas'     => 'Pilates Core Strength',
        'deskripsi'      => 'Kelas pilates intensif yang berfokus pada penguatan otot inti (core). Cocok untuk kamu yang ingin memperbaiki postur, mengurangi nyeri punggung, dan meningkatkan stabilitas tubuh.',
        'instruktur'     => 'Budi Santoso, S.Or.',
        'kuota_maksimal' => 10,
        'kuota_sisa'     => 0,
        'harga'          => 200000,
        'kategori'       => 'pilates',
        'banner_class'   => 'pilates',
    ],
    [
        'id'             => 3,
        'nama_kelas'     => 'Yoga Relax & Stretch',
        'deskripsi'      => 'Kelas yoga yang menekankan relaksasi mendalam dan peregangan seluruh otot tubuh. Sangat efektif untuk menghilangkan stres, ketegangan otot, dan meningkatkan kualitas tidur.',
        'instruktur'     => 'Anita Pratiwi, M.Kes.',
        'kuota_maksimal' => 15,
        'kuota_sisa'     => 8,
        'harga'          => 175000,
        'kategori'       => 'relax',
        'banner_class'   => 'relax',
    ],
    [
        'id'             => 4,
        'nama_kelas'     => 'Advanced Vinyasa Yoga',
        'deskripsi'      => 'Kelas vinyasa tingkat lanjut dengan rangkaian gerakan yang mengalir, dinamis, dan menantang. Disarankan untuk peserta yang sudah menguasai dasar-dasar yoga minimal 6 bulan.',
        'instruktur'     => 'Sari Dewi, S.Pd.',
        'kuota_maksimal' => 8,
        'kuota_sisa'     => 2,
        'harga'          => 250000,
        'kategori'       => 'advanced',
        'banner_class'   => 'advanced',
    ],
    [
        'id'             => 5,
        'nama_kelas'     => 'Mat Pilates',
        'deskripsi'      => 'Kelas pilates menggunakan matras dengan latihan yang terstruktur dan aman. Sangat cocok untuk pemula yang ingin mencoba pilates atau mereka yang sedang dalam proses pemulihan cedera ringan.',
        'instruktur'     => 'Budi Santoso, S.Or.',
        'kuota_maksimal' => 12,
        'kuota_sisa'     => 6,
        'harga'          => 175000,
        'kategori'       => 'pilates',
        'banner_class'   => 'pilates',
    ],
    [
        'id'             => 6,
        'nama_kelas'     => 'Meditation & Breathwork',
        'deskripsi'      => 'Sesi meditasi terstruktur dan latihan pernapasan (pranayama) yang mendalam. Dirancang untuk membantu pikiran lebih fokus, tenang, dan meningkatkan kesejahteraan mental secara keseluruhan.',
        'instruktur'     => 'Anita Pratiwi, M.Kes.',
        'kuota_maksimal' => 20,
        'kuota_sisa'     => 11,
        'harga'          => 125000,
        'kategori'       => 'relax',
        'banner_class'   => 'relax',
    ],
];

$kategoriLabel = [
    'yoga'     => 'Yoga',
    'pilates'  => 'Pilates',
    'relax'    => 'Relax & Meditasi',
    'advanced' => 'Advanced',
];
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
        <div class="class-card" @if($kelas['kuota_sisa'] > 0) onclick="openBooking('{{ addslashes($kelas['nama_kelas']) }}')" @endif>

            {{-- Banner warna kategori (menggunakan class dari frontend.css seperti di kelas.blade.php) --}}
            <div class="class-image kelas-banner {{ $kelas['banner_class'] }}">
                {{-- Jika sudah ada gambar per kelas, ganti dengan:
                <img src="{{ asset('storage/' . $kelas['gambar']) }}" alt="{{ $kelas['nama_kelas'] }}"> --}}
            </div>

            <div class="class-content">
                {{-- Badge kategori --}}
                <span class="kelas-badge">{{ $kategoriLabel[$kelas['kategori']] ?? $kelas['kategori'] }}</span>

                <h3>{{ $kelas['nama_kelas'] }}</h3>
                <p>{{ $kelas['deskripsi'] }}</p>

                {{-- Meta info: instruktur & kuota --}}
                <div class="class-meta-row">
                    <span class="class-meta-item">
                        <i class="fas fa-user-tie"></i> {{ $kelas['instruktur'] }}
                    </span>
                    <span class="class-meta-item">
                        <i class="fas fa-users"></i>
                        {{ $kelas['kuota_sisa'] }}/{{ $kelas['kuota_maksimal'] }} kursi
                        &nbsp;
                        @if ($kelas['kuota_sisa'] === 0)
                            <span class="kuota-badge full">Penuh</span>
                        @elseif ($kelas['kuota_sisa'] <= 3)
                            <span class="kuota-badge almost">Hampir Penuh</span>
                        @else
                            <span class="kuota-badge available">Tersedia</span>
                        @endif
                    </span>
                </div>

                {{-- Harga --}}
                <div class="class-price-row">
                    <span class="class-price-label">Harga per sesi</span>
                    <span class="class-price-value">Rp {{ number_format($kelas['harga'], 0, ',', '.') }}</span>
                </div>

                {{-- Tombol booking --}}
                @if ($kelas['kuota_sisa'] === 0)
                    <button class="class-btn class-btn-full" disabled>
                        <i class="fas fa-ban"></i> Kelas Penuh
                    </button>
                @else
                    @php $namaKelas = addslashes($kelas['nama_kelas']); @endphp
                    <button class="class-btn class-btn-book" onclick="openBooking('{{ $namaKelas }}')">
                        <i class="fas fa-calendar-plus"></i> Booking Kelas
                    </button>
                @endif
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
            <div class="schedule-day">RABU</div>
            <div class="schedule-day">JUMAT</div>
            <div class="schedule-day">MINGGU</div>

            <!-- Content -->
            {{-- NANTI BAGIAN INI BISA DIGANTI DENGAN DATA DARI DATABASE --}}
            {{-- @foreach($schedules->groupBy('day') as $day => $daySchedules) --}}
            
            <div class="schedule-content">
                <div class="schedule-item">08.00 - Beginner Yoga</div>
                <div class="schedule-item">12.15 - Yoga Relax & Stretch</div>
                <div class="schedule-item">16.30 - Pilates Core Strength</div>
                <div class="schedule-item">18.45 - Beginner Yoga</div>
                <div class="schedule-item">20.10 - Pilates Core Strength</div>
                
                {{-- Atau dari database:
                @foreach($daySchedules as $schedule)
                    <div class="schedule-item">{{ $schedule->time }} - {{ $schedule->class_name }}</div>
                @endforeach
                --}}
            </div>

            <div class="schedule-content">
                <div class="schedule-item">10.00 - Pilates Core Strength</div>
                <div class="schedule-item">15.15 - Beginner Yoga</div>
                <div class="schedule-item">17.10 - Yoga Relax & Stretch</div>
                <div class="schedule-item">19.25 - Pilates Core Strength</div>
                <div class="schedule-item">21.00 - Beginner Yoga</div>
            </div>

            <div class="schedule-content">
                <div class="schedule-item">08.00 - Yoga Relax & Stretch</div>
                <div class="schedule-item">13.00 - Beginner Yoga</div>
                <div class="schedule-item">16.30 - Pilates Core Strength</div>
                <div class="schedule-item">18.45 - Beginner Yoga</div>
                <div class="schedule-item">20.10 - Pilates Core Strength</div>
            </div>

            <div class="schedule-content">
                <div class="schedule-item">10.00 - Beginner Yoga</div>
                <div class="schedule-item">15.15 - Pilates Core Strength</div>
                <div class="schedule-item">17.10 - Beginner Yoga</div>
                <div class="schedule-item">19.25 - Yoga Relax & Stretch</div>
                <div class="schedule-item">21.00 - Pilates Core Strength</div>
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