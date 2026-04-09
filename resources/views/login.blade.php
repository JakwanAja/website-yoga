<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Asha Studio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Lavishly+Yours&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #a67c73; --dark: #5a2e2e; --light: #f9f5f2; --accent: #c49a9a; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: var(--light); display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .card { background: white; padding: 50px 40px; border-radius: 25px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); text-align: center; }
        .logo { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent); margin-bottom: 20px; }
        h2 { font-family: 'Lavishly Yours', cursive; font-size: 32px; color: var(--dark); }
        p.subtitle { color: var(--primary); margin-bottom: 30px; font-size: 14px; }
        .input-group { position: relative; margin-bottom: 20px; text-align: left; }
        .input-group i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--accent); }
        input { width: 100%; padding: 14px 14px 14px 42px; border: 2px solid #e8e8e8; border-radius: 12px; font-family: 'Poppins', sans-serif; font-size: 14px; background: var(--light); color: var(--dark); transition: border 0.3s; }
        input:focus { outline: none; border-color: var(--primary); background: white; }
        .btn { width: 100%; padding: 14px; background: var(--primary); color: white; border: none; border-radius: 12px; font-size: 15px; font-weight: 600; cursor: pointer; transition: background 0.3s; margin-top: 10px; }
        .btn:hover { background: var(--dark); }
        .alert { background: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; text-align: left; }
        .back-link { display: inline-block; margin-top: 20px; font-size: 13px; color: var(--primary); text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="logo">
        <h2>Asha Studio</h2>
        <p class="subtitle">Silakan Login</p>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="alert">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">
                <i class="fas fa-sign-in-alt"></i> LOGIN
            </button>
        </form>

        <a href="{{ route('home') }}" class="back-link">← Kembali ke Beranda</a>
    </div>
</body>
</html>