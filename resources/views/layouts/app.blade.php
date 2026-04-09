<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Asha Studio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lavishly+Yours&display=swap" rel="stylesheet">
    

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4eee9;
        }

        /* Navbar */
        .navbar {
        display: flex;
        justify-content: space-between; /* penting */
        align-items: center;
        padding: 25px 60px;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }

        /* kiri (menu) */
        .nav-left {
            display: flex;
            gap: 30px;
        }

        /* kanan (logo) */
        .nav-right img {
            height: 40px; /* kecil & elegan */
        }

        .navbar a {
            text-decoration: none;
            color: #555;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .nav-right img {
        height: 40px;
        width: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #c49a9a; /* garis soft */
        }

        .navbar a:hover {
            color: #000;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<!-- Navbar -->
<div class="navbar">
    
    <!-- Menu -->
    <div class="nav-left">
        <a href="{{ route('home') }}">HOME</a>
        <a href="{{ route('about') }}">ABOUT</a>
        <a href="{{ route('class') }}">CLASS</a>
        <a href="{{ route('schedule') }}">SCHEDULE</a>
    </div>

    <!-- Logo -->
    <div class="nav-right">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
    </div>

</div>

<!-- Isi halaman -->
@yield('content')

</body>
</html>