<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Asha Studio')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #ede0d4; color: #5c2d2d; }
        .font-script { font-family: 'Great Vibes', cursive; }
        .font-serif  { font-family: 'Cormorant Garamond', serif; }
        .btn-rose { background-color: #b5848c; color: #fff; transition: background .2s; }
        .btn-rose:hover { background-color: #8d5f67; }
        input::placeholder, select::placeholder {
            color: rgba(255,255,255,0.75);
            font-family: 'Cormorant Garamond', serif;
        }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: #fff;
            -webkit-box-shadow: 0 0 0px 1000px #b5848c inset;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">

    {{-- ─── NAVBAR ─── --}}
    <nav style="background-color:#ede0d4; border-bottom: 1px solid #d4bfb5;">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Nav Links --}}
            <div class="flex items-center gap-8">
                @php
                    $current = request()->path();
                    $links = [
                        ''        => 'Home',
                        'jadwal'  => 'Schedule',
                        'kelas'   => 'Class',
                        'booking' => 'Booking',
                    ];
                @endphp
               @foreach($links as $path => $label)
                    @php $active = ($current === $path || ($path !== '' && str_starts_with($current, $path))); @endphp
                    <a href="/{{ $path }}"
                    class="font-serif uppercase transition-colors {{ $active ? 'nav-active' : 'nav-inactive' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Logo Kanan --}}
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Asha Studio" class="h-10 w-auto">
            </div>
        </div>
    </nav>

    {{-- ─── MAIN CONTENT ─── --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ─── FOOTER ─── --}}
    <footer style="background-color:#d4bfb5; border-top: 1px solid #c4afa5;">
        <div class="max-w-6xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Brand --}}
            <div>
                <h3 class="font-script text-4xl mb-2" style="color:#5c2d2d;">Asha Studio</h3>
                <p class="font-serif text-sm leading-relaxed" style="color:#7a5c55;">
                    Temukan keseimbangan tubuh<br>dan pikiran bersama kami.
                </p>
            </div>

            {{-- Navigation --}}
            <div>
                <p class="font-serif uppercase tracking-widest text-xs mb-4"
                   style="color:#5c2d2d; letter-spacing:0.18em;">Navigation</p>
                <ul class="space-y-2">
                    @foreach(['/' => 'Home', '/jadwal' => 'Schedule', '/kelas' => 'Class', '/booking' => 'Booking'] as $href => $label)
                        <li>
                            <a href="{{ $href }}"
                               class="font-serif text-sm transition-colors hover:text-[#5c2d2d]"
                               style="color:#7a5c55;">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <p class="font-serif uppercase tracking-widest text-xs mb-4"
                   style="color:#5c2d2d; letter-spacing:0.18em;">Contact</p>
                <ul class="space-y-2 font-serif text-sm" style="color:#7a5c55;">
                    <li>📍 Surabaya, Jawa Timur</li>
                    <li>📞 +62 812 3456 7890</li>
                    <li>✉️ hello@ashastudio.id</li>
                    <li>📸 @ashastudio.id</li>
                </ul>
            </div>

        </div>
        <div class="text-center py-4 font-serif text-xs"
             style="color:#9e7b7b; border-top: 1px solid #c4afa5;">
            &copy; {{ date('Y') }} Asha Studio. All rights reserved.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>