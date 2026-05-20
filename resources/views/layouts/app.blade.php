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

            {{-- Flash success setelah booking berhasil --}}
            @if(session('booking_success'))
                <div style="background:#d4edda; color:#155724; border:1px solid #c3e6cb;
                            border-radius:8px; padding:12px 16px; margin-bottom:16px;
                            font-size:0.875rem; text-align:center;">
                    <i class="fas fa-check-circle"></i>
                    {{ session('booking_success') }}
                </div>
            @endif

            {{-- Error validasi booking --}}
            @if($errors->has('booking_error'))
                <div style="background:#fee2e2; color:#991b1b; border:1px solid #fca5a5;
                            border-radius:8px; padding:10px 14px; margin-bottom:14px;
                            font-size:0.85rem; text-align:center;">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first('booking_error') }}
                </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                @csrf
                <input type="hidden" name="class_name" id="classNameInput">

                {{-- Nama --}}
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        placeholder="Masukkan nama lengkap Anda"
                        value="{{ old('nama') }}"
                        maxlength="35"
                        required
                    >
                    @error('nama')
                        <span style="color:#991b1b;font-size:0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Masukkan alamat email Anda"
                        value="{{ old('email') }}"
                        maxlength="35"
                        required
                    >
                    @error('email')
                        <span style="color:#991b1b;font-size:0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Telepon --}}
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input
                        type="tel"
                        name="telephone"
                        class="form-control"
                        placeholder="Contoh: 08123456789"
                        value="{{ old('telephone') }}"
                        maxlength="13"
                        required
                    >
                    @error('telephone')
                        <span style="color:#991b1b;font-size:0.8rem;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Jadwal — diisi JS berdasarkan kelas yang dipilih --}}
                <div class="form-row-inline">
                    <div class="form-group">
                        <label>Pilih Jadwal</label>
                        <select name="id_jadwal" id="jadwalSelect" class="form-control" onchange="updatePreview(this)" required>
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
                    <li><a href="{{ route('home') }}#home">Home</a></li>
                    <li><a href="{{ route('home') }}#about">About Us</a></li>
                    <li><a href="{{ route('kelas') }}#class">Classes</a></li>
                    <li><a href="{{ route('home') }}#schedule">Schedule</a></li>
                    <!-- <li><a href="#" onclick="openLogin(); return false;">Login</a></li> -->
                </ul>
            </div>

            <div class="footer-links">
                <h4>Kelas</h4>
                <ul>
                    <li><a href="#">Beginner Yoga</a></li>
                    <li><a href="#">Pilates Core</a></li>
                    <li><a href="#">Yoga Relax</a></li>
                    <li><a href="#">Private Session</a></li>
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

        // Data jadwal dikelompokkan per nama_kelas — untuk filter select jadwal di modal booking
        var jadwalsByKelas = @json($jadwalsByKelas ?? []);
    </script>

    <!-- ========== JAVASCRIPT ========== -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Active menu on scroll
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-menu a');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').includes('#' + current)) {
                    link.classList.add('active');
                }
            });
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const hash = this.getAttribute('href').split('#')[1];
                if (!hash) return;
                const target = document.querySelector('#' + hash);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // ── Booking Modal ──────────────────────────────────
        function openBooking(className) {
            document.getElementById('bookingModal').classList.add('active');
            document.getElementById('selectedClass').textContent = className || '';
            document.getElementById('classNameInput').value = className || '';
            document.body.style.overflow = 'hidden';

            // Filter jadwal berdasarkan nama kelas yang dipilih
            filterJadwalByKelas(className);
        }

        function filterJadwalByKelas(className) {
            const select = document.getElementById('jadwalSelect');
            if (!select) return;

            // Reset select
            select.innerHTML = '<option value="">-- Pilih Jadwal --</option>';

            if (!className) return;

            // Langsung cari jadwal berdasarkan nama kelas
            const jadwals = jadwalsByKelas[className];

            if (!jadwals || jadwals.length === 0) {
                const opt = document.createElement('option');
                opt.disabled = true;
                opt.textContent = '— Belum ada jadwal untuk kelas ini —';
                select.appendChild(opt);
                return;
            }

            // Isi option jadwal sesuai kelas
            jadwals.forEach(function (j) {
                const opt = document.createElement('option');
                opt.value = j.id_jadwal;
                opt.textContent = j.label;
                if (j.disabled) {
                    opt.disabled = true;
                    opt.textContent += ' (Penuh)';
                }
                select.appendChild(opt);
            });

            // Reset preview
            const preview = document.getElementById('schedulePreview');
            if (preview) preview.classList.remove('active');
        }

        function closeBooking() {
            document.getElementById('bookingModal').classList.remove('active');
            document.body.style.overflow = 'auto';
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

        // Auto-buka modal jika ada error atau success
        document.addEventListener('DOMContentLoaded', function () {
            if (hasLoginError   === '1') openLogin();
            if (hasBookingError === '1') openBooking('{{ old('class_name', '') }}');
            if (bookingSuccess  === '1') openBooking('');
        });
    </script>

    @yield('scripts')

</body>
</html>