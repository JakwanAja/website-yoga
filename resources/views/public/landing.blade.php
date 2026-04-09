@extends('layouts.app')
@section('title', 'Asha Studio — Home')

@section('content')

{{-- ─── HERO ─── --}}
<section class="relative min-h-[88vh] flex items-center overflow-hidden" style="background-color:#ede0d4;">

    {{-- Background yoga image (right side) --}}
    <div class="absolute inset-0 flex justify-end pointer-events-none">
        <div class="w-full md:w-3/5 h-full relative">
            <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=900&auto=format&fit=crop&q=80"
                 alt="Yoga"
                 class="w-full h-full object-cover object-top"
                 style="mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.6) 30%, rgba(0,0,0,0.85) 100%);
                        -webkit-mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.6) 30%, rgba(0,0,0,0.85) 100%);">
        </div>
    </div>
    {{-- Overlay blend --}}
    <div class="absolute inset-0" style="background: linear-gradient(to right, #ede0d4 38%, rgba(237,224,212,0.55) 60%, rgba(237,224,212,0.1) 100%);"></div>

    {{-- Content --}}
    <div class="relative z-10 max-w-6xl mx-auto px-6 py-20">
        <h1 class="font-script text-7xl md:text-8xl mb-6" style="color:#5c2d2d;">Asha Studio</h1>
        <p class="font-serif text-3xl md:text-4xl font-light leading-snug mb-10 max-w-md" style="color:#5c2d2d;">
            Temukan Keseimbangan Tubuh<br>dan Pikiran Anda
        </p>
        <div class="flex items-center gap-4 flex-wrap">
            <a href="/booking" class="btn-rose font-serif tracking-widest px-8 py-3 rounded-full text-sm" style="letter-spacing:0.1em;">
                Booking
            </a>
            <a href="/jadwal" class="font-serif tracking-widest px-8 py-3 rounded-full text-sm border transition-colors hover:bg-[#b5848c] hover:text-white"
               style="border-color:#b5848c; color:#b5848c; letter-spacing:0.1em;">
                Schedule
            </a>
        </div>
    </div>
</section>

{{-- ─── STATS ─── --}}
<section style="background-color:#d4bfb5;">
    <div class="max-w-6xl mx-auto px-6 py-10 grid grid-cols-3 gap-4 text-center">
        @foreach([['500+','Member Aktif'],['3','Jenis Kelas'],['10+','Instruktur']] as $s)
        <div>
            <p class="font-script text-5xl" style="color:#5c2d2d;">{{ $s[0] }}</p>
            <p class="font-serif text-sm mt-1" style="color:#7a5c55; letter-spacing:0.06em;">{{ $s[1] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ─── CLASS CARDS ─── --}}
<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="flex items-end justify-between mb-10">
        <div>
            <p class="font-serif uppercase tracking-widest text-xs mb-1" style="color:#9e7b7b; letter-spacing:0.18em;">What We Offer</p>
            <h2 class="font-serif text-4xl font-light" style="color:#5c2d2d;">Kelas Kami</h2>
        </div>
        <a href="/kelas" class="font-serif text-sm underline" style="color:#9e7b7b;">Lihat semua →</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach([
            ['Beginner Yoga',
             'Kelas yoga untuk pemula yang ingin mengenal dasar-dasar yoga seperti teknik pernapasan, peregangan tubuh, dan keseimbangan.',
             'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=500&auto=format&fit=crop&q=80',
             '90 menit', 'Rp 85.000'],
            ['Pilates Core Strength',
             'Kelas pilates yang berfokus pada penguatan otot inti (core) seperti perut, punggung, dan pinggul. Membantu meningkatkan stabilitas tubuh.',
             'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=500&auto=format&fit=crop&q=80',
             '75 menit', 'Rp 95.000'],
            ['Yoga Relax & Stretch',
             'Kelas yoga yang dirancang untuk relaksasi mendalam dan peregangan seluruh tubuh. Cocok setelah hari yang panjang dan melelahkan.',
             'https://images.unsplash.com/photo-1588286840104-8957b019727f?w=500&auto=format&fit=crop&q=80',
             '60 menit', 'Rp 75.000'],
        ] as $kelas)
        <div class="rounded-2xl overflow-hidden flex flex-col" style="background-color:#f5ece4;">
            <div class="relative h-56 overflow-hidden">
                <img src="{{ $kelas[2] }}" alt="{{ $kelas[0] }}"
                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
            </div>
            <div class="p-6 flex flex-col flex-1">
                <h3 class="font-serif text-xl font-medium mb-2" style="color:#5c2d2d;">{{ $kelas[0] }}</h3>
                <p class="font-serif text-sm leading-relaxed flex-1 mb-4" style="color:#7a5c55;">{{ $kelas[1] }}</p>
                <div class="flex items-center justify-between mb-5">
                    <span class="font-serif text-xs" style="color:#9e7b7b;">⏱ {{ $kelas[3] }}</span>
                    <span class="font-serif text-sm font-medium" style="color:#5c2d2d;">{{ $kelas[4] }}</span>
                </div>
                <a href="/booking" class="btn-rose text-center font-serif tracking-widest text-sm py-2.5 rounded-full" style="letter-spacing:0.1em;">
                    Booking
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ─── JADWAL PREVIEW ─── --}}
<section class="py-16" style="background-color:#f5ece4;">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="font-serif uppercase tracking-widest text-xs mb-1" style="color:#9e7b7b; letter-spacing:0.18em;">This Week</p>
                <h2 class="font-serif text-4xl font-light" style="color:#5c2d2d;">Jadwal Minggu Ini</h2>
            </div>
            <a href="/jadwal" class="font-serif text-sm underline" style="color:#9e7b7b;">Lihat semua →</a>
        </div>

        {{-- Table with bg image --}}
        <div class="relative rounded-2xl overflow-hidden" style="min-height: 340px;">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1545389336-cf090694435e?w=1200&auto=format&fit=crop&q=80"
                     alt="bg" class="w-full h-full object-cover">
                <div class="absolute inset-0" style="background: rgba(180,140,120,0.72);"></div>
            </div>
            <div class="relative z-10 p-6">
                <table class="w-full text-center">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.3);">
                            @foreach(['SENIN','RABU','JUMAT','MINGGU'] as $hari)
                            <th class="font-serif font-semibold py-4 text-white tracking-widest text-sm" style="letter-spacing:0.15em;">{{ $hari }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $jadwal = [
                            ['08.00 - Beginner Yoga',        '10.00 - Pilates Core Strength', '08.00 - Yoga Relax & Stretch',  '10.00 - Beginner Yoga'],
                            ['12.15 - Yoga Relax & Stretch', '15.15 - Beginner Yoga',         '13.00 - Beginner Yoga',          '15.15 - Pilates Core Strength'],
                            ['16.30 - Pilates Core Strength','17.10 - Yoga Relax & Stretch',  '16.30 - Pilates Core Strength',  '17.10 - Beginner Yoga'],
                            ['20.45 - Beginner Yoga',        '19.25 - Pilates Core Strength', '20.45 - Beginner Yoga',          '19.25 - Yoga Relax & Stretch'],
                            ['20.10 - Pilates Core Strength','21.00 - Beginner Yoga',         '20.10 - Pilates Core Strength',  '21.00 - Pilates Core Strength'],
                        ];
                        @endphp
                        @foreach($jadwal as $row)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.15);">
                            @foreach($row as $item)
                            <td class="font-serif text-sm py-4 px-2 text-white" style="font-weight:300; line-height:1.5;">
                                {{ $item }}
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

{{-- ─── CTA ─── --}}
<section class="py-20 text-center" style="background-color:#ede0d4;">
    <h2 class="font-script text-6xl mb-4" style="color:#5c2d2d;">Mulai Perjalanan Anda</h2>
    <p class="font-serif text-lg font-light mb-8" style="color:#9e7b7b;">Bergabunglah bersama ratusan member yang telah merasakan manfaatnya.</p>
    <a href="/booking" class="btn-rose font-serif tracking-widest px-10 py-4 rounded-full text-sm inline-block" style="letter-spacing:0.15em;">
        Book Kelas Sekarang
    </a>
</section>

@endsection