<!DOCTYPE html>
<html>
<head>
    <title>Super Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            background: #e8dccf;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: #6b3e3e;
            color: white;
            padding: 25px;
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

        /* Content */
        .content {
            flex: 1;
            padding: 30px;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>Super Admin</h2>
    <a href="{{ route('superadmin.dashboard') }}">Dashboard</a>
    <a href="{{ route('superadmin.admin') }}">Kelola Admin</a>
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>