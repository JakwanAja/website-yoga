<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lavishly+Yours&display=swap" rel="stylesheet">
    
    <style>
        body {
            margin: 0;
            font-family: Poppins, sans-serif;
            display: flex;
        }

        .sidebar {
            width: 220px;
            height: 100vh;
            background: #5a2e2e;
            color: white;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin-bottom: 15px;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        .content {
            flex: 1;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>Admin</h2>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="#">Booking</a>
    <a href="#">Class</a>
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>