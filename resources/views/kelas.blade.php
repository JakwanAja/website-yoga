@extends('layouts.app')

@section('title', 'Jadwal Kelas - Asha Studio')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
@endsection

@section('content')

    {{-- ========== DATA DUMMY HARDCODE (ganti dengan data dari DB nanti) ========== --}}
    {{-- Data diambil dari DB via View::composer sebagai $kelases --}}
    @php
        $kelasList = $kelases ?? collect();
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
                    <span>3</span>
                </div>
            </div>
        </div>

        {{-- Grid Kelas --}}
        <div class="kelas-grid" id="kelasGrid">

            @forelse ($kelasList as $kelas)
                <div class="kelas-card" data-nama="{{ strtolower($kelas->nama) }}"
                    data-instruktur="{{ strtolower($kelas->instruktur) }}">

                    <div class="kelas-body">
                        {{-- Judul --}}
                        <h3>{{ $kelas->nama }}</h3>

                        {{-- Deskripsi --}}
                        <p class="kelas-desc">{{ \Illuminate\Support\Str::limit($kelas->keterangan, 180) }}</p>

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
                                    <span class="kuota-badge available">Tersedia</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div class="kelas-price">
                        <span class="price-label">Harga per sesi</span>
                        <div>
                            <span class="price-value">Rp {{ number_format($kelas->harga ?? 0, 0, ',', '.') }}</span>
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
    const kelasData = @json($kelasList);

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
        window.openBooking = function (namaKelas) {
            alert(`Halaman booking untuk kelas "${namaKelas}" akan segera tersedia!`);
        };
    }

    console.log('Halaman Kelas loaded ✓');
</script>