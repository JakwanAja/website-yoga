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
        $kelasList      = ($kelases ?? collect())->take(4);
        $jadwalPerKelas = ($jadwals ?? collect())
            ->groupBy(fn($j) => $j->kelas->nama_kelas ?? '');
    @endphp

    <section id="class" class="class-section">
        <div class="section-header">
            <span class="section-tag">KELAS KAMI</span>
            <h2 class="section-title">Pilih Kelas Favorit Anda</h2>
        </div>
        <div class="class-grid">

            @foreach ($kelasList as $kelas)
                @php
                    $gradients = [
                        'linear-gradient(135deg, #667eea, #764ba2)',
                        'linear-gradient(135deg, #ff9a9e, #fad0c4)',
                        'linear-gradient(135deg, #a18cd1, #fbc2eb)',
                        'linear-gradient(135deg, #f6d365, #fda085)'
                    ];
                    $bg        = $gradients[$loop->index % count($gradients)];
                    $inisial   = strtoupper(substr($kelas->nama_kelas, 0, 1));
                    $hasGambar = !empty($kelas->foto) && file_exists(public_path('uploads/kelas/' . $kelas->foto));

                    $jadwalKelas    = $jadwalPerKelas[$kelas->nama_kelas] ?? collect();
                    $sisaKuotaTotal = $jadwalKelas->sum('sisa_kuota');
                    $adaJadwal      = $jadwalKelas->count() > 0;
                    $penuh          = $adaJadwal && $sisaKuotaTotal <= 0;
                @endphp

                <div class="class-card">
                    <div class="class-image" style="overflow:hidden;">
                        @if($hasGambar)
                            <img src="{{ asset('uploads/kelas/' . $kelas->foto) }}"
                                 alt="{{ $kelas->nama_kelas }}"
                                 style="width:100%; height:100%; object-fit:cover; display:block;">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:{{ $bg }};font-size:48px;color:#fff;font-weight:bold;">
                                {{ $inisial }}
                            </div>
                        @endif
                    </div>

                    <div class="class-content">

                        <h3>{{ $kelas->nama_kelas }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($kelas->deskripsi, 140) }}</p>

                        {{-- Meta info: instruktur & status kuota --}}
                        <div class="class-meta-row">
                            <span class="class-meta-item">
                                <i class="fas fa-user-tie"></i> {{ $kelas->instruktur }}
                            </span>
                            <span class="class-meta-item">
                                @if(!$adaJadwal)
                                    <span class="kuota-badge" style="background:#e5e7eb;color:#6b7280;">Belum Ada Jadwal</span>
                                @elseif($penuh)
                                    <span class="kuota-badge" style="background:#fee2e2;color:#991b1b;">Penuh</span>
                                @else
                                    <span class="kuota-badge available">Tersedia</span>
                                @endif
                            </span>
                        </div>

                        {{-- Jadwal tersedia --}}
                        @if($adaJadwal)
                            <div class="kelas-jadwal" style="margin-top:10px;">
                                <p style="font-size:0.78rem;font-weight:600;color:#7c6b5e;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">
                                    <i class="fas fa-calendar-alt"></i> Jadwal Tersedia
                                </p>
                                <div style="display:flex;flex-wrap:wrap;gap:6px;">
                                    @foreach($jadwalKelas as $jadwal)
                                        @php $habis = $jadwal->sisa_kuota !== null && $jadwal->sisa_kuota <= 0; @endphp
                                        <span style="
                                            font-size:0.75rem;
                                            padding:3px 10px;
                                            border-radius:20px;
                                            background:{{ $habis ? '#fee2e2' : '#f0fdf4' }};
                                            color:{{ $habis ? '#991b1b' : '#166534' }};
                                            border:1px solid {{ $habis ? '#fca5a5' : '#86efac' }};
                                        ">
                                            {{ ucfirst($jadwal->hari) }},
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} WIB
                                            @if($habis) · Penuh @endif
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Harga --}}
                        <div class="class-price-row">
                            <span class="class-price-label">Harga per sesi</span>
                            <span class="class-price-value">Rp {{ number_format($kelas->biaya ?? 0, 0, ',', '.') }}</span>
                        </div>

                        {{-- Tombol Booking --}}
                        <button class="class-btn class-btn-book"
                                onclick="openBooking('{{ addslashes($kelas->nama_kelas) }}')"
                                {{ $penuh ? 'disabled style=opacity:0.5;cursor:not-allowed;' : '' }}>
                            <i class="fas fa-calendar-plus"></i>
                            {{ $penuh ? 'Kelas Penuh' : 'Booking Kelas' }}
                        </button>

                    </div>
                </div>
            @endforeach

        </div>

        {{-- Tombol lihat semua kelas --}}
        <div style="text-align:center; margin-top: 50px;">
            <a href="{{ route('kelas') }}" class="btn btn-outline">
                <i class="fas fa-th-large"></i> Lihat Semua Kelas
            </a>
        </div>
    </section>

    <!-- ========== SCHEDULE SECTION ========== -->
    @php
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        // FIX: groupBy lowercase karena nilai 'hari' di DB disimpan lowercase (senin, selasa, dst)
        $jadwalByHari = ($jadwals ?? collect())->groupBy(fn($j) => ucfirst(strtolower($j->hari)));
    @endphp

    <section id="schedule" class="schedule-section">
        <div class="section-header">
            <span class="section-tag">JADWAL KELAS</span>
            <h2 class="section-title">Jadwal Mingguan Kami</h2>
        </div>
        <div class="schedule-container">
            <div class="schedule-table">
                {{-- Header hari — strtoupper agar tetap tampil kapital semua --}}
                @foreach($hariList as $hari)
                    <div class="schedule-day">{{ strtoupper($hari) }}</div>
                @endforeach

                {{-- Content jadwal per hari --}}
                @foreach($hariList as $hari)
                    <div class="schedule-content">
                        @if(isset($jadwalByHari[$hari]) && $jadwalByHari[$hari]->count() > 0)
                            @foreach($jadwalByHari[$hari] as $jadwal)
                                <div class="schedule-item">
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H.i') }}
                                    - {{ $jadwal->kelas->nama_kelas ?? '—' }}
                                </div>
                            @endforeach
                        @else
                            <div style="color:#bbb; font-size:13px; text-align:center; padding-top:8px;">—</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        console.log('Beranda loaded successfully!');
    </script>
@endsection