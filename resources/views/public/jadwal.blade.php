@extends('layouts.app')
@section('title', 'Schedule — Asha Studio')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-14">

    {{-- Header --}}
    <div class="flex items-end justify-between mb-10">
        <div>
            <h2 class="font-serif uppercase tracking-widest text-sm mb-1" style="color:#9e7b7b; letter-spacing:0.18em;">SCHEDULE</h2>
            <p class="font-script text-6xl" style="color:#5c2d2d;">Asha Studio</p>
        </div>
        {{-- Filter Hari --}}
        <div class="flex gap-2 flex-wrap justify-end" id="filter-btns">
            @foreach(['Semua','Senin','Rabu','Jumat','Minggu'] as $hari)
            <button onclick="filterHari('{{ $hari }}')"
                data-hari="{{ $hari }}"
                class="filter-btn font-serif text-xs tracking-widest px-4 py-2 rounded-full border transition-all"
                style="border-color:#b5848c; color:#b5848c; letter-spacing:0.1em;">
                {{ strtoupper($hari) }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- Table with bg --}}
    <div class="relative rounded-2xl overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1545389336-cf090694435e?w=1400&auto=format&fit=crop&q=80"
                 alt="bg" class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background: rgba(180,140,120,0.72);"></div>
        </div>

        <div class="relative z-10 p-6 overflow-x-auto">
            <table class="w-full text-center min-w-[600px]" id="jadwal-table">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.35);">
                        @foreach([
                            ['Senin','#'],
                            ['Rabu','#'],
                            ['Jumat','#'],
                            ['Minggu','#'],
                        ] as [$hari, $_])
                        <th class="jadwal-col font-serif font-semibold py-5 text-white tracking-widest text-sm"
                            data-hari="{{ $hari }}"
                            style="letter-spacing:0.18em;">
                            {{ strtoupper($hari) }}
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                    $jadwal = [
                        [
                            ['jam'=>'08.00','kelas'=>'Beginner Yoga','kuota'=>8,'sisa'=>3],
                            ['jam'=>'10.00','kelas'=>'Pilates Core Strength','kuota'=>10,'sisa'=>0],
                            ['jam'=>'08.00','kelas'=>'Yoga Relax & Stretch','kuota'=>12,'sisa'=>5],
                            ['jam'=>'10.00','kelas'=>'Beginner Yoga','kuota'=>8,'sisa'=>2],
                        ],
                        [
                            ['jam'=>'12.15','kelas'=>'Yoga Relax & Stretch','kuota'=>10,'sisa'=>7],
                            ['jam'=>'15.15','kelas'=>'Beginner Yoga','kuota'=>8,'sisa'=>4],
                            ['jam'=>'13.00','kelas'=>'Beginner Yoga','kuota'=>8,'sisa'=>0],
                            ['jam'=>'15.15','kelas'=>'Pilates Core Strength','kuota'=>10,'sisa'=>6],
                        ],
                        [
                            ['jam'=>'16.30','kelas'=>'Pilates Core Strength','kuota'=>10,'sisa'=>2],
                            ['jam'=>'17.10','kelas'=>'Yoga Relax & Stretch','kuota'=>12,'sisa'=>9],
                            ['jam'=>'16.30','kelas'=>'Pilates Core Strength','kuota'=>10,'sisa'=>1],
                            ['jam'=>'17.10','kelas'=>'Beginner Yoga','kuota'=>8,'sisa'=>3],
                        ],
                        [
                            ['jam'=>'20.45','kelas'=>'Beginner Yoga','kuota'=>8,'sisa'=>0],
                            ['jam'=>'19.25','kelas'=>'Pilates Core Strength','kuota'=>10,'sisa'=>5],
                            ['jam'=>'20.45','kelas'=>'Beginner Yoga','kuota'=>8,'sisa'=>4],
                            ['jam'=>'19.25','kelas'=>'Yoga Relax & Stretch','kuota'=>12,'sisa'=>8],
                        ],
                        [
                            ['jam'=>'20.10','kelas'=>'Pilates Core Strength','kuota'=>10,'sisa'=>3],
                            ['jam'=>'21.00','kelas'=>'Beginner Yoga','kuota'=>8,'sisa'=>2],
                            ['jam'=>'20.10','kelas'=>'Pilates Core Strength','kuota'=>10,'sisa'=>0],
                            ['jam'=>'21.00','kelas'=>'Pilates Core Strength','kuota'=>10,'sisa'=>7],
                        ],
                    ];
                    $hariList = ['Senin','Rabu','Jumat','Minggu'];
                    @endphp

                    @foreach($jadwal as $row)
                    <tr class="jadwal-row" style="border-bottom: 1px solid rgba(255,255,255,0.15);">
                        @foreach($row as $i => $item)
                        <td class="jadwal-col py-5 px-3 align-top" data-hari="{{ $hariList[$i] }}">
                            <p class="font-serif text-white text-sm font-medium">{{ $item['jam'] }}</p>
                            <p class="font-serif text-white text-xs mt-1 leading-snug" style="font-weight:300;">{{ $item['kelas'] }}</p>
                            @if($item['sisa'] === 0)
                                <span class="inline-block mt-2 font-serif text-xs px-2 py-0.5 rounded-full"
                                      style="background:rgba(180,60,60,0.35); color:#ffd0d0; letter-spacing:0.05em;">
                                    Penuh
                                </span>
                            @else
                                <span class="inline-block mt-2 font-serif text-xs px-2 py-0.5 rounded-full"
                                      style="background:rgba(80,160,100,0.35); color:#c8f5d0; letter-spacing:0.05em;">
                                    {{ $item['sisa'] }} slot
                                </span>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- CTA --}}
    <div class="text-center mt-12">
        <a href="/booking" class="btn-rose font-serif tracking-widest px-10 py-4 rounded-full text-sm inline-block" style="letter-spacing:0.15em;">
            Book Kelas Sekarang
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
function filterHari(hari) {
    // Update active button style
    document.querySelectorAll('.filter-btn').forEach(btn => {
        const isActive = btn.dataset.hari === hari;
        btn.style.backgroundColor = isActive ? '#b5848c' : 'transparent';
        btn.style.color = isActive ? '#fff' : '#b5848c';
    });

    const cols = document.querySelectorAll('.jadwal-col');
    cols.forEach(col => {
        if (hari === 'Semua' || !col.dataset.hari || col.dataset.hari === hari) {
            col.style.display = '';
        } else {
            col.style.display = 'none';
        }
    });
}

// Set default active
document.addEventListener('DOMContentLoaded', () => filterHari('Semua'));
</script>
@endpush