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
            gap: 30px;
            padding: 25px 60px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .navbar a {
            text-decoration: none;
            color: #555;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .navbar a:hover {
            color: #000;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="{{ route('home') }}">HOME</a>
    <a href="{{ route('about') }}">ABOUT</a>
    <a href="{{ route('class') }}">CLASS</a>
    <a href="{{ route('schedule') }}">SCHEDULE</a>
</div>

<!-- Isi halaman -->
@yield('content')

</body>
</html>