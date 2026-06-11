<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Asha Studio - Yoga & Pilates')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&family=Lavishly+Yours&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')

    <style>
        /* ── Booking Success Modal ──────────────────────── */
        #successModal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(20, 8, 8, 0.55);
            backdrop-filter: blur(6px);
            align-items: center;
            justify-content: center;
        }
        #successModal.active {
            display: flex;
        }
        .success-modal-box {
            background: #fff;
            border-radius: 24px;
            padding: 44px 40px 36px;
            max-width: 420px;
            width: calc(100% - 40px);
            text-align: center;
            box-shadow: 0 24px 64px rgba(90, 46, 46, 0.22);
            animation: successPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }
        @keyframes successPop {
            from { transform: scale(0.85) translateY(20px); opacity: 0; }
            to   { transform: scale(1)    translateY(0);    opacity: 1; }
        }
        .success-icon-ring {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #c8e6c9, #a5d6a7);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            color: #2e7d32;
            animation: checkPop 0.5s 0.2s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }
        @keyframes checkPop {
            from { transform: scale(0); }
            to   { transform: scale(1); }
        }
        .success-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #3a1a1a;
            margin-bottom: 10px;
        }
        .success-desc {
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
            color: #7a5a5a;
            line-height: 1.65;
            margin-bottom: 28px;
        }
        .success-countdown {
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            color: #b08a8a;
            margin-bottom: 20px;
        }
        .success-countdown span {
            font-weight: 700;
            color: #a67c73;
            font-size: 1rem;
        }
        .success-progress {
            width: 100%;
            height: 4px;
            background: #f0e8e8;
            border-radius: 99px;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .success-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #a67c73, #c49a8a);
            border-radius: 99px;
            width: 100%;
            transition: width linear;
        }
        .success-btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background: linear-gradient(135deg, #a67c73, #c49a8a);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.2s, transform 0.2s;
        }
        .success-btn-home:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <!-- ========== NAVBAR ========== -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="nav-logo">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Asha Studio Logo">
            <span class="nav-logo-text">Asha Studio</span>
        </a>
        <ul class="nav-menu">
            <li><a href="{{ route('home') }}#home" class="{{ Request::is('/') ? 'active' : '' }}">BERANDA</a></li>
            <li><a href="{{ route('home') }}#about">TENTANG</a></li>
            <li><a href="{{ route('kelas') }}">KELAS</a></li>
            <li><a href="{{ route('home') }}#schedule">JADWAL</a></li>
        </ul>
    </nav>

    <!-- ========== MAIN CONTENT ========== -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- ========== LOGIN MODAL ========== -->
    <div id="loginModal" class="modal">
        <div class="modal-content login-modal-content">
            <button class="modal-close" onclick="closeLogin()">&times;</button>
            
            <div class="logo-circle">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
            </div>

            <h2 class="modal-title">Asha Studio</h2>
            <p class="modal-subtitle">Silakan Login</p>

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                @if ($errors->has('login'))
                    <div style="background:#fee2e2; color:#991b1b; border:1px solid #fca5a5;
                                border-radius:8px; padding:10px 14px; margin-bottom:14px;
                                font-size:0.85rem; text-align:center;">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first('login') }}
                    </div>
                @endif

                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" class="form-control" placeholder="Username"
                           value="{{ old('username') }}" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="fas fa-sign-in-alt"></i> LOGIN
                </button>

                <div style="text-align:center; margin-top: 14px;">
                    <a href="#" onclick="openForgotPassword(); return false;"
                       style="font-size: 0.85rem; color: var(--primary); text-decoration: none; opacity: 0.8;">
                        <i class="fas fa-key"></i> Lupa Password?
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- ========== BOOKING MODAL ========== -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeBooking()">&times;</button>
            <h2 class="modal-title">Formulir Booking</h2>
            <p class="modal-subtitle" id="selectedClass">Beginner Yoga</p>

            {{-- Error validasi booking --}}
            @if($errors->any() && !$errors->has('login'))
                <div style="background:#fee2e2; color:#991b1b; border:1px solid #fca5a5;
                            border-radius:8px; padding:10px 14px; margin-bottom:14px;
                            font-size:0.85rem; text-align:center;">
                    <i class="fas fa-exclamation-circle"></i>
                    Mohon periksa kembali data yang diisi.
                </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                @csrf
                <input type="hidden" name="class_name" id="classNameInput">

                {{-- Nama --}}
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control"
                           placeholder="Masukkan nama lengkap Anda"
                           value="{{ old('nama') }}" maxlength="35" required>
                    @error('nama')
                        <span style="color:#991b1b;font-size:0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="Masukkan alamat email Anda"
                           value="{{ old('email') }}" maxlength="35" required>
                    @error('email')
                        <span style="color:#991b1b;font-size:0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Telepon --}}
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="tel" name="telephone" class="form-control"
                           placeholder="Contoh: 08123456789"
                           value="{{ old('telephone') }}" maxlength="13" required>
                    @error('telephone')
                        <span style="color:#991b1b;font-size:0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Jadwal --}}
                <div class="form-row-inline">
                    <div class="form-group">
                        <label>Pilih Jadwal</label>
                        <select name="id_jadwal" id="jadwalSelect" class="form-control"
                                onchange="updatePreview(this)" required>
                            <option value="">-- Pilih Jadwal --</option>
                        </select>
                        @error('id_jadwal')
                            <span style="color:#991b1b;font-size:0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div id="schedulePreview" class="schedule-preview"></div>

                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="fas fa-check"></i> Konfirmasi Booking
                </button>
            </form>
        </div>
    </div>

    <!-- ========== SUCCESS MODAL ========== -->
    <div id="successModal">
        <div class="success-modal-box">
            <div class="success-icon-ring">
                <i class="fas fa-check"></i>
            </div>
            <div class="success-title">Booking Berhasil!</div>
            <p class="success-desc">
                Terima kasih telah mendaftar di <strong>Asha Studio</strong>.<br>
                Kami akan segera menghubungi Anda untuk konfirmasi jadwal.
            </p>
            <div class="success-progress">
                <div class="success-progress-bar" id="successProgressBar"></div>
            </div>
            <div class="success-countdown">
                Kembali ke beranda dalam <span id="countdownNum">3</span> detik...
            </div>
            <a href="{{ route('home') }}" class="success-btn-home">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- ========== FOOTER ========== -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h3>Asha Studio</h3>
                <p>
                    Studio yoga dan pilates terbaik di Bikini Bottom. 
                    Kami berkomitmen untuk membantu Anda mencapai kesehatan dan keseimbangan hidup yang optimal.
                </p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('home') }}#home">Beranda</a></li>
                    <li><a href="{{ route('home') }}#about">Tentang Kami</a></li>
                    <li><a href="{{ route('kelas') }}#class">Kelas</a></li>
                    <li><a href="{{ route('home') }}#schedule">Jadwal</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Kelas</h4>
                <ul>
                    <li><a href="#">Viyasa Flow</a></li>
                    <li><a href="#">Hatha Flow</a></li>
                    <li><a href="#">Parental Group Session</a></li>
                    <li><a href="#">Parental Yoga Reguler</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Kontak</h4>
                <ul>
                    <li><i class="fas fa-phone"></i> +62 812-3456-7890</li>
                    <li><i class="fas fa-envelope"></i> info@ashastudio.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Bonokeling No.1, Demangan, Kec. Taman, Kota Madiun, Jawa Timur 63136</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 Asha Studio. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- ========== INJECT BLADE VARIABLE KE JS ========== -->
    <script>
        var hasLoginError   = "{{ $errors->has('login') ? '1' : '0' }}";
        var hasBookingError = "{{ ($errors->any() && !$errors->has('login')) ? '1' : '0' }}";
        var bookingSuccess  = "{{ session('booking_success') ? '1' : '0' }}";
        var homeUrl         = "{{ route('home') }}";

        // Data jadwal dikelompokkan per nama_kelas
        var jadwalsByKelas = @json($jadwalsByKelas ?? []);
    </script>

    <!-- ========== JAVASCRIPT ========== -->
    <script>
        // ── Navbar scroll ──────────────────────────────────
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // ── Active menu on scroll ──────────────────────────
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-menu a');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                if (pageYOffset >= section.offsetTop - 200)
                    current = section.getAttribute('id');
            });
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').includes('#' + current))
                    link.classList.add('active');
            });
        });

        // ── Booking Modal ──────────────────────────────────
        function openBooking(className) {
            document.getElementById('bookingModal').classList.add('active');
            document.getElementById('selectedClass').textContent = className || '';
            document.getElementById('classNameInput').value = className || '';
            document.body.style.overflow = 'hidden';
            filterJadwalByKelas(className);
        }

        function closeBooking() {
            document.getElementById('bookingModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function filterJadwalByKelas(className) {
            const select = document.getElementById('jadwalSelect');
            if (!select) return;
            select.innerHTML = '<option value="">-- Pilih Jadwal --</option>';
            if (!className) return;

            const jadwals = jadwalsByKelas[className];
            if (!jadwals || jadwals.length === 0) {
                const opt = document.createElement('option');
                opt.disabled = true;
                opt.textContent = '— Belum ada jadwal untuk kelas ini —';
                select.appendChild(opt);
                return;
            }
            jadwals.forEach(function(j) {
                const opt = document.createElement('option');
                opt.value = j.id_jadwal;
                opt.textContent = j.label;
                if (j.disabled) {
                    opt.disabled = true;
                    opt.textContent += ' (Penuh)';
                }
                select.appendChild(opt);
            });
            const preview = document.getElementById('schedulePreview');
            if (preview) preview.classList.remove('active');
        }

        function updatePreview(select) {
            const preview = document.getElementById('schedulePreview');
            if (select.value !== '') {
                preview.textContent = '✓ Jadwal dipilih: ' + select.options[select.selectedIndex].text;
                preview.classList.add('active');
            } else {
                preview.classList.remove('active');
            }
        }

        // ── Login Modal ────────────────────────────────────
        function openLogin() {
            document.getElementById('loginModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLogin() {
            document.getElementById('loginModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function openForgotPassword() { /* placeholder */ }
        function closeForgotPassword() { /* placeholder */ }
        function backToLogin() {
            document.getElementById('loginModal').classList.add('active');
        }

        // Close modal on outside click
        window.onclick = function(event) {
            if (event.target == document.getElementById('bookingModal')) closeBooking();
            if (event.target == document.getElementById('loginModal'))   closeLogin();
        }

        // ── Success Modal + Countdown ──────────────────────
        function openSuccessModal() {
            document.body.style.overflow = 'hidden';
            document.getElementById('successModal').classList.add('active');

            const DURATION = 3; // detik
            let remaining  = DURATION;
            const numEl    = document.getElementById('countdownNum');
            const barEl    = document.getElementById('successProgressBar');

            // Mulai animasi progress bar
            // Sedikit delay agar transisi CSS aktif setelah render
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    barEl.style.transition = `width ${DURATION}s linear`;
                    barEl.style.width      = '0%';
                });
            });

            // Countdown angka tiap detik
            const timer = setInterval(() => {
                remaining--;
                numEl.textContent = remaining;
                if (remaining <= 0) {
                    clearInterval(timer);
                    window.location.href = homeUrl;
                }
            }, 1000);
        }

        // ── Auto-trigger on load ───────────────────────────
        document.addEventListener('DOMContentLoaded', function () {
            if (hasLoginError   === '1') openLogin();
            if (hasBookingError === '1') openBooking('{{ old('class_name', '') }}');
            if (bookingSuccess  === '1') openSuccessModal();
        });
    </script>

    @yield('scripts')

</body>
</html>