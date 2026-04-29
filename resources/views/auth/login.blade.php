<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Asha Studio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&family=Lavishly+Yours&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <section class="login-page">
        <div class="modal-content login-modal-content">
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
                    <input id="username" type="text" name="username" class="form-control" placeholder="Username"
                           value="{{ old('username') }}" required autofocus>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="fas fa-sign-in-alt"></i> LOGIN
                </button>
            </form>
        </div>
    </section>
</body>
</html>
