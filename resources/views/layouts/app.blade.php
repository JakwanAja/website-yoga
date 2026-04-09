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

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #a67c73;
            --secondary: #e8dccf;
            --dark: #5a2e2e;
            --light: #f9f5f2;
            --accent: #c49a9a;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }

        /* ========== NAVBAR ========== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 60px;
            background: rgba(249, 245, 242, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 15px 60px;
            box-shadow: 0 2px 30px rgba(0,0,0,0.1);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .nav-logo img {
            height: 45px;
            width: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent);
        }

        .nav-logo-text {
            font-family: 'Lavishly Yours', cursive;
            font-size: 28px;
            color: var(--dark);
        }

        .nav-menu {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-menu a {
            text-decoration: none;
            color: var(--dark);
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.5px;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-menu a:hover {
            color: var(--primary);
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        .nav-menu a.active {
            color: var(--primary);
        }

        .nav-menu a.active::after {
            width: 100%;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            padding-top: 80px;
            min-height: calc(100vh - 80px);
        }

        /* ========== MODAL ========== */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(5px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 50px;
            border-radius: 25px;
            width: 90%;
            max-width: 600px;
            position: relative;
            animation: slideUp 0.3s ease;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
            color: var(--dark);
            transition: all 0.3s ease;
            background: none;
            border: none;
        }

        .modal-close:hover {
            transform: rotate(90deg);
            color: var(--primary);
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: var(--dark);
            margin-bottom: 15px;
            text-align: center;
        }

        .modal-subtitle {
            font-size: 18px;
            color: var(--primary);
            margin-bottom: 40px;
            text-align: center;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: var(--dark);
            margin-bottom: 10px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border-radius: 12px;
            border: 2px solid #e8e8e8;
            background: var(--light);
            color: var(--dark);
            font-size: 15px;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
        }

        .form-control::placeholder {
            color: #aaa;
        }

        select.form-control {
            cursor: pointer;
        }

        .schedule-preview {
            margin-top: 20px;
            padding: 20px;
            background: var(--primary);
            color: white;
            border-radius: 12px;
            text-align: center;
            font-size: 16px;
            font-weight: 500;
            display: none;
        }

        .schedule-preview.active {
            display: block;
            animation: slideDown 0.3s ease;
        }

        .btn {
            padding: 16px 40px;
            border-radius: 50px;
            border: none;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(166, 124, 115, 0.3);
        }

        .btn-primary:hover {
            background: #8f6a62;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(166, 124, 115, 0.4);
        }

        .btn-submit {
            width: 100%;
            margin-top: 30px;
        }

        /* Login Modal Specific */
        .login-modal-content {
            max-width: 500px;
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            background: var(--primary);
            border-radius: 50%;
            margin: 0 auto 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-circle img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 16px;
        }

        .input-group input {
            padding-left: 50px;
        }

        /* ========== FOOTER ========== */
        .footer {
            background: var(--dark);
            color: white;
            padding: 60px 80px 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 60px;
            max-width: 1400px;
            margin: 0 auto 40px;
        }

        .footer-brand h3 {
            font-family: 'Lavishly Yours', cursive;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .footer-brand p {
            line-height: 1.8;
            color: #ccc;
            margin-bottom: 20px;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-links h4 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links ul li {
            margin-bottom: 12px;
        }

        .footer-links ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links ul li a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #ccc;
            font-size: 14px;
        }

        /* ========== ANIMATIONS ========== */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .navbar {
                padding: 15px 30px;
            }

            .nav-menu {
                gap: 20px;
                font-size: 13px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .modal-content {
                padding: 30px;
            }
        }
    </style>

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
            <li><a href="{{ route('home') }}#home" class="{{ Request::is('/') ? 'active' : '' }}">HOME</a></li>
            <li><a href="{{ route('home') }}#about">ABOUT</a></li>
            <li><a href="{{ route('home') }}#class">CLASS</a></li>
            <li><a href="{{ route('home') }}#schedule">SCHEDULE</a></li>
            <li><a href="#" onclick="openLogin()">LOGIN</a></li>
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
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="fas fa-sign-in-alt"></i> LOGIN
                </button>
            </form>
        </div>
    </div>

    <!-- ========== BOOKING MODAL ========== -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeBooking()">&times;</button>
            <h2 class="modal-title">Formulir Booking</h2>
            <p class="modal-subtitle" id="selectedClass">Beginner Yoga</p>

            <form action="#" method="POST" onsubmit="return handleBooking(event)">
                @csrf
                <input type="hidden" name="class_name" id="classNameInput">

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap Anda" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email Anda" required>
                </div>

                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="tel" name="phone" class="form-control" placeholder="Masukkan nomor telepon Anda" required>
                </div>

                <div class="form-group">
                    <label>Pilih Jadwal</label>
                    <select name="jadwal" class="form-control" onchange="updatePreview(this)" required>
                        <option value="">-- Pilih Jadwal --</option>
                        <option value="Senin, 08.00 WIB">Senin, 08.00 WIB</option>
                        <option value="Rabu, 10.00 WIB">Rabu, 10.00 WIB</option>
                        <option value="Jumat, 16.00 WIB">Jumat, 16.00 WIB</option>
                        <option value="Minggu, 10.00 WIB">Minggu, 10.00 WIB</option>
                    </select>
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
                    Studio yoga dan pilates terbaik di Surakarta. 
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
                    <li><a href="{{ route('home') }}#class">Classes</a></li>
                    <li><a href="{{ route('home') }}#schedule">Schedule</a></li>
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
                    <li><i class="fas fa-map-marker-alt"></i> Surakarta, Jawa Tengah</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 Asha Studio. All Rights Reserved. Made with <i class="fas fa-heart" style="color: var(--primary);"></i></p>
        </div>
    </footer>

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
                const sectionHeight = section.clientHeight;
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
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href').split('#')[1] ? '#' + this.getAttribute('href').split('#')[1] : 'body');
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Booking Modal
        function openBooking(className) {
            document.getElementById('bookingModal').classList.add('active');
            document.getElementById('selectedClass').textContent = className;
            document.getElementById('classNameInput').value = className;
            document.body.style.overflow = 'hidden';
        }

        function closeBooking() {
            document.getElementById('bookingModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function updatePreview(select) {
            const preview = document.getElementById('schedulePreview');
            if (select.value !== '') {
                preview.textContent = '✓ Jadwal dipilih: ' + select.value;
                preview.classList.add('active');
            } else {
                preview.classList.remove('active');
            }
        }

        function handleBooking(event) {
            // Jika ingin submit ke server, hapus kode di bawah ini
            event.preventDefault();
            alert('Booking berhasil! Kami akan menghubungi Anda segera.');
            closeBooking();
            event.target.reset();
            document.getElementById('schedulePreview').classList.remove('active');
            return false;
        }
            // Sesudah — hapus semua isinya, biarkan form submit normal
            function handleLogin(event) {
                return true;
            }
        // Login Modal
        function openLogin() {
            document.getElementById('loginModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLogin() {
            document.getElementById('loginModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }
        // Close modal when clicking outside
        window.onclick = function(event) {
            const bookingModal = document.getElementById('bookingModal');
            const loginModal = document.getElementById('loginModal');
            
            if (event.target == bookingModal) {
                closeBooking();
            }
            if (event.target == loginModal) {
                closeLogin();
            }
        }

    </script>

        // Auto-buka modal login jika ada error dari server
        @if ($errors->any() || session('error'))
            document.addEventListener('DOMContentLoaded', function() {
                openLogin();
            });
        @endif
    @yield('scripts')


</body>
</html>