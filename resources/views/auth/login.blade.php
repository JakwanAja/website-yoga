<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Asha Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cormorant+Garamond:wght@300;400;500&family=Lato:wght@300;400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #ede0d4;
        }
        .font-script {
            font-family: 'Great Vibes', cursive;
        }
        .font-serif-elegant {
            font-family: 'Cormorant Garamond', serif;
        }
        .bg-card {
            background-color: #f5ece4;
        }
        .bg-input {
            background-color: #b5848c;
        }
        .bg-button {
            background-color: #a07078;
        }
        .bg-button:hover {
            background-color: #8d5f67;
        }
        .logo-circle {
            background-color: #e8ddd5;
            border: 2px solid #d4bfb5;
        }
        input::placeholder {
            color: rgba(255, 255, 255, 0.75);
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            letter-spacing: 0.02em;
        }
        input {
            color: #fff;
            background: transparent;
            outline: none;
            border: none;
            width: 100%;
        }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: #fff;
            -webkit-box-shadow: 0 0 0px 1000px #b5848c inset;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-lg">

        {{-- Card --}}
        <div class="bg-card rounded-3xl shadow-2xl px-10 pt-6 pb-12 relative">

            {{-- Logo Circle (overlapping top) --}}
            <div class="flex justify-center -mt-14 mb-2">
                <div class="logo-circle w-24 h-24 rounded-full flex items-center justify-center shadow-md">
                    {{-- Lotus / Yoga SVG Icon --}}
                    <svg viewBox="0 0 60 60" class="w-12 h-12" fill="none" xmlns="xxxxxxxxxxx">
                        <path d="M30 45 C30 45 15 35 15 22 C15 15 22 10 30 14 C38 10 45 15 45 22 C45 35 30 45 30 45Z"
                            fill="#8d6e63" opacity="0.25"/>
                        <path d="M30 42 C30 42 20 30 22 20 C24 13 30 12 30 12 C30 12 36 13 38 20 C40 30 30 42 30 42Z"
                            fill="#7a5c55" opacity="0.45"/>
                        <path d="M30 14 Q26 22 28 32 Q30 38 30 42 Q30 38 32 32 Q34 22 30 14Z"
                            fill="#6d4c41" opacity="0.6"/>
                        <circle cx="30" cy="20" r="3.5" fill="#8d6e63" opacity="0.5"/>
                    </svg>
                </div>
            </div>

            {{-- Brand Name --}}
            <h1 class="font-script text-center text-6xl mb-1" style="color: #5c2d2d; letter-spacing: 0.02em;">
                Asha Studio
            </h1>
            <p class="text-center font-serif-elegant text-sm tracking-widest mb-8" style="color: #9e7b7b; letter-spacing: 0.18em;">
                ADMIN PANEL
            </p>

            {{-- Alert Error --}}
            @if (session('error'))
                <div class="mb-5 flex items-start gap-3 rounded-2xl px-4 py-3 text-sm"
                    style="background-color: rgba(180,80,80,0.12); border: 1px solid rgba(180,80,80,0.25); color: #8d3a3a;">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9h2v4H9V9zm0-3h2v2H9V6z"
                            clip-rule="evenodd"/>
                    </svg>
                    <span class="font-serif-elegant">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="mb-5 flex items-start gap-3 rounded-2xl px-4 py-3 text-sm"
                    style="background-color: rgba(100,150,100,0.12); border: 1px solid rgba(100,150,100,0.25); color: #4a7a55;">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"/>
                    </svg>
                    <span class="font-serif-elegant">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                {{-- Email Field --}}
                <div>
                    <div class="bg-input flex items-center gap-4 rounded-2xl px-5 py-4 @error('email') ring-2 ring-red-300 @enderror">
                        {{-- User Icon --}}
                        <svg class="w-6 h-6 shrink-0" fill="white" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                        </svg>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Silahkan masukan email anda"
                            required
                            autofocus
                        >
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs font-serif-elegant pl-2" style="color: #8d3a3a;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <div class="bg-input flex items-center gap-4 rounded-2xl px-5 py-4 @error('password') ring-2 ring-red-300 @enderror">
                        {{-- Lock Icon --}}
                        <svg class="w-6 h-6 shrink-0" fill="white" viewBox="0 0 24 24">
                            <path d="M12 1C9.24 1 7 3.24 7 6v1H5c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2h-2V6c0-2.76-2.24-5-5-5zm0 2c1.66 0 3 1.34 3 3v1H9V6c0-1.66 1.34-3 3-3zm0 9c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/>
                        </svg>
                        <input
                            type="password"
                            name="password"
                            placeholder="Silahkan masukan password anda"
                            required
                        >
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs font-serif-elegant pl-2" style="color: #8d3a3a;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center gap-2 pl-1">
                    <input type="checkbox" id="remember" name="remember"
                        class="w-4 h-4 rounded accent-[#a07078] cursor-pointer">
                    <label for="remember" class="text-sm font-serif-elegant cursor-pointer" style="color: #9e7b7b; letter-spacing: 0.04em;">
                        Ingat saya
                    </label>
                </div>

                {{-- Login Button --}}
                <div class="flex justify-center pt-2">
                    <button type="submit"
                        class="bg-button text-white font-serif-elegant tracking-widest text-sm px-20 py-4 rounded-2xl transition-all duration-200 shadow-md hover:shadow-lg active:scale-95"
                        style="letter-spacing: 0.2em;">
                        LOGIN
                    </button>
                </div>

            </form>

        </div>

        {{-- Footer --}}
        <p class="text-center text-xs mt-6 font-serif-elegant" style="color: #b09a90; letter-spacing: 0.08em;">
            &copy; {{ date('Y') }} Yoga Studio. All rights reserved.
        </p>

    </div>

</body>
</html>