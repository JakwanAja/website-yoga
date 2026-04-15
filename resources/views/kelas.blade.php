@extends('layouts.app')

@section('title', 'Jadwal Kelas - Asha Studio')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
@endsection

@section('content')

{{-- ========== DATA DUMMY HARDCODE (ganti dengan data dari DB nanti) ========== --}}
@php
$kelasList = [
    [
        'id'             => 1,
        'nama_kelas'     => 'Beginner Yoga',
        'deskripsi'      => 'Kelas yoga dasar yang dirancang khusus untuk pemula. Kamu akan belajar teknik pernapasan, gerakan dasar asana, dan melatih keseimbangan tubuh secara perlahan dan menyenangkan.',
        'instruktur'     => 'Sari Dewi, S.Pd.',
        'kuota_maksimal' => 12,
        'kuota_sisa'     => 4,
        'harga'          => 150000,
        'kategori'       => 'yoga',
        'banner_class'   => 'yoga',
        'dibuat_pada'    => '2025-01-10 08:00:00',
        'diubah_pada'    => '2025-03-15 09:30:00',
    ],
    [
        'id'             => 2,
        'nama_kelas'     => 'Pilates Core Strength',
        'deskripsi'      => 'Kelas pilates intensif yang berfokus pada penguatan otot inti (core). Cocok untuk kamu yang ingin memperbaiki postur, mengurangi nyeri punggung, dan meningkatkan stabilitas tubuh.',
        'instruktur'     => 'Budi Santoso, S.Or.',
        'kuota_maksimal' => 10,
        'kuota_sisa'     => 0,
        'harga'          => 200000,
        'kategori'       => 'pilates',
        'banner_class'   => 'pilates',
        'dibuat_pada'    => '2025-01-12 10:00:00',
        'diubah_pada'    => '2025-04-01 11:00:00',
    ],
    [
        'id'             => 3,
        'nama_kelas'     => 'Yoga Relax & Stretch',
        'deskripsi'      => 'Kelas yoga yang menekankan relaksasi mendalam dan peregangan seluruh otot tubuh. Sangat efektif untuk menghilangkan stres, ketegangan otot, dan meningkatkan kualitas tidur.',
        'instruktur'     => 'Anita Pratiwi, M.Kes.',
        'kuota_maksimal' => 15,
        'kuota_sisa'     => 8,
        'harga'          => 175000,
        'kategori'       => 'relax',
        'banner_class'   => 'relax',
        'dibuat_pada'    => '2025-02-05 09:00:00',
        'diubah_pada'    => '2025-03-20 14:00:00',
    ],
    [
        'id'             => 4,
        'nama_kelas'     => 'Advanced Vinyasa Yoga',
        'deskripsi'      => 'Kelas vinyasa tingkat lanjut dengan rangkaian gerakan yang mengalir, dinamis, dan menantang. Disarankan untuk peserta yang sudah menguasai dasar-dasar yoga minimal 6 bulan.',
        'instruktur'     => 'Sari Dewi, S.Pd.',
        'kuota_maksimal' => 8,
        'kuota_sisa'     => 2,
        'harga'          => 250000,
        'kategori'       => 'advanced',
        'banner_class'   => 'advanced',
        'dibuat_pada'    => '2025-02-20 08:00:00',
        'diubah_pada'    => '2025-04-10 09:00:00',
    ],
    [
        'id'             => 5,
        'nama_kelas'     => 'Mat Pilates',
        'deskripsi'      => 'Kelas pilates menggunakan matras dengan latihan yang terstruktur dan aman. Sangat cocok untuk pemula yang ingin mencoba pilates atau mereka yang sedang dalam proses pemulihan cedera ringan.',
        'instruktur'     => 'Budi Santoso, S.Or.',
        'kuota_maksimal' => 12,
        'kuota_sisa'     => 6,
        'harga'          => 175000,
        'kategori'       => 'pilates',
        'banner_class'   => 'pilates',
        'dibuat_pada'    => '2025-03-01 08:00:00',
        'diubah_pada'    => '2025-04-05 10:00:00',
    ],
    [
        'id'             => 6,
        'nama_kelas'     => 'Meditation & Breathwork',
        'deskripsi'      => 'Sesi meditasi terstruktur dan latihan pernapasan (pranayama) yang mendalam. Dirancang untuk membantu pikiran lebih fokus, tenang, dan meningkatkan kesejahteraan mental secara keseluruhan.',
        'instruktur'     => 'Anita Pratiwi, M.Kes.',
        'kuota_maksimal' => 20,
        'kuota_sisa'     => 11,
        'harga'          => 125000,
        'kategori'       => 'relax',
        'banner_class'   => 'relax',
        'dibuat_pada'    => '2025-03-10 07:00:00',
        'diubah_pada'    => '2025-04-12 08:00:00',
    ],
];

$kategoriLabel = [
    'yoga'     => 'Yoga',
    'pilates'  => 'Pilates',
    'relax'    => 'Relax & Meditasi',
    'advanced' => 'Advanced',
];
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
    <div class="filter-chips">
        <button class="chip active" onclick="filterByKategori('semua', this)">Semua</button>
        <button class="chip" onclick="filterByKategori('yoga', this)">Yoga</button>
        <button class="chip" onclick="filterByKategori('pilates', this)">Pilates</button>
        <button class="chip" onclick="filterByKategori('relax', this)">Relax & Meditasi</button>
        <button class="chip" onclick="filterByKategori('advanced', this)">Advanced</button>
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
                <span>{{ count($kelasList) }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
            <div class="stat-info">
                <p>INSTRUKTUR</p>
                <span>3</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <p>TOTAL KUOTA</p>
                <span>{{ array_sum(array_column($kelasList, 'kuota_maksimal')) }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-door-open"></i></div>
            <div class="stat-info">
                <p>KURSI TERSISA</p>
                <span>{{ array_sum(array_column($kelasList, 'kuota_sisa')) }}</span>
            </div>
        </div>
    </div>

    {{-- Grid Kelas --}}
    <div class="kelas-grid" id="kelasGrid">

        @forelse ($kelasList as $kelas)
        <div class="kelas-card"
             data-kategori="{{ $kelas['kategori'] }}"
             data-nama="{{ strtolower($kelas['nama_kelas']) }}"
             data-instruktur="{{ strtolower($kelas['instruktur']) }}">

            {{-- Banner warna kategori --}}
            <div class="kelas-banner {{ $kelas['banner_class'] }}"></div>

            <div class="kelas-body">
                {{-- Badge --}}
                <span class="kelas-badge">{{ $kategoriLabel[$kelas['kategori']] ?? $kelas['kategori'] }}</span>

                {{-- Judul --}}
                <h3>{{ $kelas['nama_kelas'] }}</h3>

                {{-- Deskripsi --}}
                <p class="kelas-desc">{{ $kelas['deskripsi'] }}</p>

                {{-- Meta info --}}
                <div class="kelas-meta">
                    <div class="kelas-meta-item">
                        <i class="fas fa-user-tie"></i>
                        <span><strong>Instruktur:</strong> {{ $kelas['instruktur'] }}</span>
                    </div>
                    <div class="kelas-meta-item">
                        <i class="fas fa-users"></i>
                        <span>
                            <strong>Kuota:</strong>
                            {{ $kelas['kuota_sisa'] }}/{{ $kelas['kuota_maksimal'] }} kursi tersedia
                            @if ($kelas['kuota_sisa'] === 0)
                                <span class="kuota-badge full">Penuh</span>
                            @elseif ($kelas['kuota_sisa'] <= 3)
                                <span class="kuota-badge available">Hampir Penuh</span>
                            @else
                                <span class="kuota-badge available">Tersedia</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Harga --}}
            <div class="kelas-price">
                <span class="price-label">Harga per sesi</span>
                <div>
                    <span class="price-value">Rp {{ number_format($kelas['harga'], 0, ',', '.') }}</span>
                    <span class="price-per"> /sesi</span>
                </div>
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
            <button class="btn-booking" id="modalBookingBtn" onclick="">
                <i class="fas fa-calendar-plus"></i> Booking Sekarang
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // ============================================================
    // DATA DUMMY (mirror PHP data — nanti bisa di-replace dengan
    // data dari API/controller)
    // ============================================================
    //const kelasData = @json($kelasList);

    // ============================================================
    // FILTER: search input
    // ============================================================
    let activeKategori = 'semua';

    function filterKelas() {
        const q = document.getElementById('searchInput').value.toLowerCase().trim();
        const cards = document.querySelectorAll('#kelasGrid .kelas-card');

        cards.forEach(card => {
            const nama       = card.dataset.nama;
            const instruktur = card.dataset.instruktur;
            const kategori   = card.dataset.kategori;

            const matchSearch   = nama.includes(q) || instruktur.includes(q);
            const matchKategori = activeKategori === 'semua' || kategori === activeKategori;

            card.style.display = (matchSearch && matchKategori) ? '' : 'none';
        });
    }

    // ============================================================
    // FILTER: chip kategori
    // ============================================================
    function filterByKategori(kategori, btn) {
        activeKategori = kategori;
        document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        filterKelas();
    }

    // ============================================================
    // MODAL DETAIL
    // ============================================================
    function openDetail(id) {
        const k = kelasData.find(x => x.id === id);
        if (!k) return;

        document.getElementById('modalNama').textContent = k.nama_kelas;
        document.getElementById('modalDesc').textContent = k.deskripsi;

        const isFull = k.kuota_sisa === 0;

        document.getElementById('modalMeta').innerHTML = `
            <div class="kelas-meta-item">
                <i class="fas fa-user-tie"></i>
                <span><strong>Instruktur:</strong> ${k.instruktur}</span>
            </div>
            <div class="kelas-meta-item">
                <i class="fas fa-users"></i>
                <span><strong>Kuota:</strong> ${k.kuota_sisa}/${k.kuota_maksimal} kursi tersedia</span>
            </div>
            <div class="kelas-meta-item">
                <i class="fas fa-tag"></i>
                <span><strong>Harga:</strong> Rp ${Number(k.harga).toLocaleString('id-ID')} / sesi</span>
            </div>
        `;

        document.getElementById('modalDates').innerHTML = `
            <span>📅 Dibuat: ${formatDate(k.dibuat_pada)}</span>
            <span>🔄 Diperbarui: ${formatDate(k.diubah_pada)}</span>
        `;

        const btn = document.getElementById('modalBookingBtn');
        if (isFull) {
            btn.textContent = 'Kelas Penuh';
            btn.disabled = true;
            btn.style.background = '#ccc';
            btn.style.cursor = 'not-allowed';
        } else {
            btn.innerHTML = '<i class="fas fa-calendar-plus"></i> Booking Sekarang';
            btn.disabled = false;
            btn.style.background = '';
            btn.style.cursor = '';
            btn.onclick = () => { closeDetail(); openBooking(k.nama_kelas); };
        }

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

    // ============================================================
    // HELPER: format tanggal
    // ============================================================
    function formatDate(str) {
        if (!str) return '-';
        const d = new Date(str);
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
    }

    // ============================================================
    // BOOKING (panggil fungsi openBooking dari layouts.app atau
    // definisikan di sini jika belum ada)
    // ============================================================
    if (typeof openBooking === 'undefined') {
        window.openBooking = function(namaKelas) {
            alert(`Halaman booking untuk kelas "${namaKelas}" akan segera tersedia!`);
        };
    }

    console.log('Halaman Kelas loaded ✓');
</script>
@endsection