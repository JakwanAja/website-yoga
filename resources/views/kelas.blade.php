@extends('layouts.app')

@section('title', 'Jadwal Kelas - Asha Studio')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
@endsection

@section('content')

    @php
        $kelasList   = $kelases ?? collect();
        // Kelompokkan jadwal aktif per nama kelas untuk ditampilkan di card
        $jadwalPerKelas = ($jadwals ?? collect())
            ->groupBy(fn($j) => $j->kelas->nama_kelas ?? '');
    @endphp

    <!-- ========== PAGE HEADER ========== -->
    <section class="page-header">
        <span class="page-header-tag">Asha Studio</span>
        <h1>Jadwal Kelas</h1>
        <p>Temukan kelas yang paling sesuai dengan kebutuhan dan tujuan wellness-mu. Daftarkan dirimu sekarang!</p>
    </section>

    <!-- ========== FILTER BAR ========== -->
    <div class="filter-bar">
        <div class="filter-search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama kelas atau instruktur..." oninput="filterKelas()">
        </div>
    </div>

    <!-- ========== KELAS SECTION ========== -->
    <section class="kelas-section">

        {{-- Stats Row --}}
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                <div class="stat-info">
                    <p>TOTAL KELAS</p>
                    <span>{{ $kelasList->count() }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
                <div class="stat-info">
                    <p>INSTRUKTUR</p>
                    <span>{{ $kelasList->pluck('instruktur')->unique()->count() }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-info">
                    <p>TOTAL JADWAL</p>
                    <span>{{ ($jadwals ?? collect())->count() }}</span>
                </div>
            </div>
        </div>

        {{-- Grid Kelas --}}
        <div class="kelas-grid" id="kelasGrid">

            @forelse ($kelasList as $kelas)
                @php
                    $gradients = [
                        'linear-gradient(135deg, #667eea, #764ba2)',
                        'linear-gradient(135deg, #ff9a9e, #fad0c4)',
                        'linear-gradient(135deg, #a18cd1, #fbc2eb)',
                        'linear-gradient(135deg, #f6d365, #fda085)'
                    ];
                    $bg       = $gradients[$loop->index % count($gradients)];
                    $inisial  = strtoupper(substr($kelas->nama_kelas, 0, 1));
                    // FIX: nama field foto (bukan gambar), nama_kelas (bukan nama)
                    $hasGambar = !empty($kelas->foto) && file_exists(public_path('uploads/kelas/' . $kelas->foto));

                    // Ambil jadwal untuk kelas ini
                    $jadwalKelas = $jadwalPerKelas[$kelas->nama_kelas] ?? collect();

                    // Hitung sisa kuota total dari semua jadwal kelas ini
                    $sisaKuotaTotal = $jadwalKelas->sum('sisa_kuota');
                    $adaJadwal      = $jadwalKelas->count() > 0;
                    $penuh          = $adaJadwal && $sisaKuotaTotal <= 0;
                @endphp

                <div class="kelas-card"
                    {{-- FIX: data-nama dan data-instruktur pakai field yang benar --}}
                    data-nama="{{ strtolower($kelas->nama_kelas) }}"
                    data-instruktur="{{ strtolower($kelas->instruktur) }}">

                    <div class="kelas-banner" style="height:200px; overflow:hidden;">
                        @if($hasGambar)
                            {{-- FIX: pakai $kelas->foto (bukan $kelas->gambar) --}}
                            <img src="{{ asset('uploads/kelas/' . $kelas->foto) }}"
                                 alt="{{ $kelas->nama_kelas }}"
                                 style="width:100%; height:100%; object-fit:cover; display:block;">
                        @else
                            {{-- Fallback jika tidak ada foto --}}
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;
                                        background:{{ $bg }}; font-size:56px; color:#fff; font-weight:bold;">
                                {{ $inisial }}
                            </div>
                        @endif
                    </div>

                    <div class="kelas-body">
                        {{-- FIX: pakai nama_kelas --}}
                        <h3>{{ $kelas->nama_kelas }}</h3>

                        {{-- FIX: pakai deskripsi (bukan keterangan) --}}
                        <p class="kelas-desc">{{ \Illuminate\Support\Str::limit($kelas->deskripsi, 180) }}</p>

                        {{-- Meta info --}}
                        <div class="kelas-meta">
                            <div class="kelas-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span><strong>Instruktur:</strong> {{ $kelas->instruktur }}</span>
                            </div>
                            <div class="kelas-meta-item">
                                <i class="fas fa-users"></i>
                                <span>
                                    <strong>Status:</strong>
                                    @if(!$adaJadwal)
                                        <span class="kuota-badge" style="background:#e5e7eb; color:#6b7280;">Belum Ada Jadwal</span>
                                    @elseif($penuh)
                                        <span class="kuota-badge" style="background:#fee2e2; color:#991b1b;">Penuh</span>
                                    @else
                                        <span class="kuota-badge available">Tersedia</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Jadwal tersedia untuk kelas ini --}}
                        @if($adaJadwal)
                            <div class="kelas-jadwal" style="margin-top:12px;">
                                <p style="font-size:0.78rem; font-weight:600; color:#7c6b5e; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.05em;">
                                    <i class="fas fa-calendar-alt"></i> Jadwal Tersedia
                                </p>
                                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                                    @foreach($jadwalKelas as $jadwal)
                                        @php
                                            $habis = $jadwal->sisa_kuota !== null && $jadwal->sisa_kuota <= 0;
                                        @endphp
                                        <span style="
                                            font-size:0.75rem;
                                            padding:3px 10px;
                                            border-radius:20px;
                                            background: {{ $habis ? '#fee2e2' : '#f0fdf4' }};
                                            color: {{ $habis ? '#991b1b' : '#166534' }};
                                            border: 1px solid {{ $habis ? '#fca5a5' : '#86efac' }};
                                        ">
                                            {{ ucfirst($jadwal->hari) }},
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} WIB
                                            @if($habis) · Penuh @endif
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- FIX: pakai biaya (bukan harga) --}}
                    <div class="kelas-price">
                        <span class="price-label">Harga per sesi</span>
                        <div>
                            <span class="price-value">Rp {{ number_format($kelas->biaya ?? 0, 0, ',', '.') }}</span>
                            <span class="price-per"> /sesi</span>
                        </div>
                    </div>

                    {{-- Tombol Booking --}}
                    <div class="kelas-footer">
                        {{-- FIX: pakai nama_kelas (bukan nama) --}}
                        <button class="btn-booking" onclick="openBooking('{{ addslashes($kelas->nama_kelas) }}')"
                            {{ $penuh ? 'disabled style=opacity:0.5;cursor:not-allowed;' : '' }}>
                            <i class="fas fa-calendar-plus"></i>
                            {{ $penuh ? 'Kelas Penuh' : 'Booking Kelas' }}
                        </button>
                    </div>

                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>Belum ada kelas tersedia saat ini.</p>
                </div>
            @endforelse

        </div>
    </section>

    <!-- ========== MODAL DETAIL ========== -->
    <div class="modal-overlay" id="modalDetail" onclick="closeDetailOnOverlay(event)">
        <div class="modal-box">
            <div class="modal-header">
                <h2 id="modalNama">-</h2>
                <button class="modal-close" onclick="closeDetail()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="kelas-meta" id="modalMeta"></div>
                <p class="modal-desc" id="modalDesc">-</p>
                <div class="modal-dates" id="modalDates"></div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeDetail()">Tutup</button>
                <button class="btn-booking" id="modalBookingBtn">
                    <i class="fas fa-calendar-plus"></i> Booking Sekarang
                </button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // ============================================================
    // FILTER: search input
    // ============================================================
    function filterKelas() {
        const q = document.getElementById('searchInput').value.toLowerCase().trim();
        const cards = document.querySelectorAll('#kelasGrid .kelas-card');

        cards.forEach(card => {
            const nama = card.dataset.nama;
            const instruktur = card.dataset.instruktur;
            const matchSearch = nama.includes(q) || instruktur.includes(q);
            card.style.display = matchSearch ? '' : 'none';
        });
    }

    // ============================================================
    // MODAL DETAIL
    // ============================================================
    function openDetail(id) {
        // FIX: pakai field yang benar: nama_kelas, deskripsi, biaya
        const k = kelasData.find(x => x.id_kelas === id);
        if (!k) return;

        document.getElementById('modalNama').textContent = k.nama_kelas;
        document.getElementById('modalDesc').textContent = k.deskripsi;

        document.getElementById('modalMeta').innerHTML = `
            <div class="kelas-meta-item">
                <i class="fas fa-user-tie"></i>
                <span><strong>Instruktur:</strong> ${k.instruktur}</span>
            </div>
            <div class="kelas-meta-item">
                <i class="fas fa-tag"></i>
                <span><strong>Harga:</strong> Rp ${Number(k.biaya).toLocaleString('id-ID')} / sesi</span>
            </div>
        `;

        document.getElementById('modalDetail').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeDetail() {
        document.getElementById('modalDetail').classList.remove('open');
        document.body.style.overflow = '';
    }

    function closeDetailOnOverlay(e) {
        if (e.target.id === 'modalDetail') closeDetail();
    }

    // Tombol booking di modal
    document.getElementById('modalBookingBtn').onclick = function() {
        const namaKelas = document.getElementById('modalNama').textContent;
        closeDetail();
        openBooking(namaKelas);
    };

    console.log('Halaman Kelas loaded ✓');
</script>
@endsection