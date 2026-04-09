@extends('layouts.app')

@section('title', 'Beranda - Asha Studio')

@section('styles')
<style>
    /* ========== HERO SECTION ========== */
    .hero {
        display: flex;
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    .hero-left {
        width: 50%;
        padding: 80px 80px 80px 100px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        animation: fadeInLeft 1s ease;
    }

    .hero-title {
        font-family: 'Lavishly Yours', cursive;
        font-size: 80px;
        color: var(--dark);
        margin-bottom: 20px;
        line-height: 1;
    }

    .hero-subtitle {
        font-size: 32px;
        color: var(--dark);
        line-height: 1.4;
        margin-bottom: 40px;
        font-weight: 300;
    }

    .hero-description {
        font-size: 16px;
        color: #7a5a5a;
        line-height: 1.8;
        margin-bottom: 50px;
        max-width: 500px;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
    }

    .btn-outline {
        background: transparent;
        color: var(--dark);
        border: 2px solid var(--primary);
    }

    .btn-outline:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .hero-right {
        width: 50%;
        position: relative;
        overflow: hidden;
        animation: fadeInRight 1s ease;
    }

    .hero-right img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .hero-right:hover img {
        transform: scale(1.05);
    }

    /* ========== ABOUT SECTION ========== */
    .about-section {
        display: flex;
        min-height: 100vh;
        background: var(--secondary);
    }

    .about-left {
        width: 50%;
        position: relative;
        overflow: hidden;
    }

    .about-left img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .about-left:hover img {
        transform: scale(1.05);
    }

    .about-right {
        width: 50%;
        padding: 100px 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .section-tag {
        font-size: 14px;
        color: var(--primary);
        letter-spacing: 3px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .about-title {
        font-family: 'Lavishly Yours', cursive;
        font-size: 64px;
        color: var(--dark);
        margin-bottom: 30px;
        line-height: 1;
    }

    .about-subtitle {
        font-size: 28px;
        color: var(--dark);
        margin-bottom: 30px;
        font-weight: 400;
    }

    .about-text {
        font-size: 16px;
        color: #7a5a5a;
        line-height: 1.9;
        margin-bottom: 30px;
        max-width: 550px;
    }

    .about-location {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 15px;
        color: var(--dark);
        margin-top: 20px;
    }

    .about-location i {
        color: var(--primary);
        font-size: 18px;
    }

    /* ========== CLASS SECTION ========== */
    .class-section {
        padding: 100px 80px;
        background: var(--light);
    }

    .section-header {
        text-align: center;
        margin-bottom: 80px;
    }

    .section-header .section-tag {
        display: block;
        margin: 0 auto 20px;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 48px;
        color: var(--dark);
        margin-bottom: 20px;
    }

    .class-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .class-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .class-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }

    .class-image {
        width: 100%;
        height: 280px;
        overflow: hidden;
    }

    .class-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .class-card:hover .class-image img {
        transform: scale(1.1);
    }

    .class-content {
        padding: 30px;
    }

    .class-content h3 {
        font-size: 24px;
        color: var(--dark);
        margin-bottom: 15px;
        font-family: 'Playfair Display', serif;
    }

    .class-content p {
        font-size: 14px;
        color: #7a5a5a;
        line-height: 1.8;
        margin-bottom: 25px;
    }

    .class-btn {
        width: 100%;
        padding: 14px;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .class-btn:hover {
        background: #8f6a62;
        transform: translateY(-2px);
    }

    /* ========== SCHEDULE SECTION ========== */
    .schedule-section {
        padding: 100px 80px;
        background: var(--secondary);
    }

    .schedule-container {
        max-width: 1400px;
        margin: 0 auto;
        background: white;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0,0,0,0.1);
    }

    .schedule-table {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }

    .schedule-day {
        padding: 30px 20px;
        text-align: center;
        background: var(--primary);
        color: white;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 1px;
        border-right: 1px solid rgba(255,255,255,0.2);
    }

    .schedule-day:last-child {
        border-right: none;
    }

    .schedule-content {
        padding: 35px 25px;
        font-size: 14px;
        line-height: 2.2;
        color: var(--dark);
        border-right: 1px solid #e8e8e8;
        border-top: 1px solid #e8e8e8;
        background: var(--light);
    }

    .schedule-content:last-child {
        border-right: none;
    }

    .schedule-item {
        margin-bottom: 10px;
        padding: 8px 12px;
        background: white;
        border-radius: 8px;
        border-left: 3px solid var(--primary);
        transition: all 0.3s ease;
    }

    .schedule-item:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    /* ========== ANIMATIONS ========== */
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .hero, .about-section {
            flex-direction: column;
        }

        .hero-left, .hero-right,
        .about-left, .about-right {
            width: 100%;
        }

        .hero-left, .about-right {
            padding: 60px 30px;
        }

        .hero-title {
            font-size: 50px;
        }

        .hero-subtitle {
            font-size: 24px;
        }

        .class-grid {
            grid-template-columns: 1fr;
            padding: 0 30px;
        }

        .schedule-table {
            grid-template-columns: 1fr;
        }

        .class-section, .schedule-section {
            padding: 60px 30px;
        }
    }
</style>
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
<section id="class" class="class-section">
    <div class="section-header">
        <span class="section-tag">KELAS KAMI</span>
        <h2 class="section-title">Pilih Kelas Favorit Anda</h2>
    </div>
    <div class="class-grid">
        
        {{-- NANTI BAGIAN INI BISA DIGANTI DENGAN DATA DARI DATABASE --}}
        {{-- @foreach($classes as $class) --}}
        
        <!-- Card 1 -->
        <div class="class-card" onclick="openBooking('Beginner Yoga')">
            <div class="class-image">
                <img src="{{ asset('images/yoga1.jpeg') }}" alt="Beginner Yoga">
                {{-- Atau dari database: <img src="{{ asset('storage/' . $class->image) }}" alt="{{ $class->name }}"> --}}
            </div>
            <div class="class-content">
                <h3>Beginner Yoga</h3>
                {{-- Atau dari database: <h3>{{ $class->name }}</h3> --}}
                <p>
                    Kelas yoga untuk pemula yang ingin mengenal dasar-dasar yoga
                    seperti teknik pernapasan, peregangan tubuh, dan keseimbangan.
                    Cocok untuk semua level kebugaran.
                </p>
                {{-- Atau dari database: <p>{{ $class->description }}</p> --}}
                <button class="class-btn">
                    <i class="fas fa-calendar-plus"></i> Booking Kelas
                </button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="class-card" onclick="openBooking('Pilates Core Strength')">
            <div class="class-image">
                <img src="{{ asset('images/yoga2.jpeg') }}" alt="Pilates Core">
            </div>
            <div class="class-content">
                <h3>Pilates Core Strength</h3>
                <p>
                    Kelas pilates yang berfokus pada penguatan otot inti (core)
                    untuk meningkatkan stabilitas tubuh dan memperbaiki postur.
                    Tingkatkan kekuatan inti Anda dengan efektif.
                </p>
                <button class="class-btn">
                    <i class="fas fa-calendar-plus"></i> Booking Kelas
                </button>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="class-card" onclick="openBooking('Yoga Relax')">
            <div class="class-image">
                <img src="{{ asset('images/yoga3.jpeg') }}" alt="Yoga Relax">
            </div>
            <div class="class-content">
                <h3>Yoga Relax & Stretch</h3>
                <p>
                    Kelas yoga yang berfokus pada relaksasi tubuh dan pikiran
                    melalui gerakan lembut dan teknik pernapasan.
                    Sempurna untuk menghilangkan stress.
                </p>
                <button class="class-btn">
                    <i class="fas fa-calendar-plus"></i> Booking Kelas
                </button>
            </div>
        </div>

        {{-- @endforeach --}}
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