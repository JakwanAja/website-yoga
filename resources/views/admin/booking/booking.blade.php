@extends('layouts.admin')

@section('title', 'Manajemen Booking')
@section('page-title', 'Manajemen Booking')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('content')

<div class="bk-summary">
    <div class="bk-stat-card">
        <div class="bk-stat-icon" style="background:rgba(166,124,115,0.12);color:var(--primary)">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div>
            <div class="bk-stat-value">{{ $total }}</div>
            <div class="bk-stat-label">Total Booking</div>
        </div>
    </div>
    <div class="bk-stat-card">
        <div class="bk-stat-icon" style="background:rgba(201,169,110,0.12);color:var(--warning)">
            <i class="fas fa-hourglass-half"></i>
        </div>
        <div>
            <div class="bk-stat-value">{{ $statusCount['booking'] }}</div>
            <div class="bk-stat-label">Menunggu Konfirmasi</div>
        </div>
    </div>
    <div class="bk-stat-card">
        <div class="bk-stat-icon" style="background:rgba(122,158,181,0.12);color:var(--info)">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <div class="bk-stat-value">{{ $statusCount['terkonfirmasi'] }}</div>
            <div class="bk-stat-label">Terkonfirmasi</div>
        </div>
    </div>
    <div class="bk-stat-card">
        <div class="bk-stat-icon" style="background:rgba(106,158,127,0.12);color:var(--success)">
            <i class="fas fa-user-check"></i>
        </div>
        <div>
            <div class="bk-stat-value">{{ $statusCount['hadir'] + $statusCount['selesai'] }}</div>
            <div class="bk-stat-label">Hadir / Selesai</div>
        </div>
    </div>
</div>

<div class="panel">

    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-calendar-check" style="color:var(--primary);margin-right:8px;font-size:16px"></i>
            Daftar Booking
        </div>

        {{-- Filter Bar --}}
        <form method="GET" action="{{ route('admin.booking') }}" class="bk-filter-bar">

            {{-- Search --}}
            <div class="bk-search-wrap">
                <i class="fas fa-search bk-search-icon"></i>
                <input type="text" name="search" placeholder="Cari nama, email, telepon..."
                       value="{{ request('search') }}" class="bk-search-input">
            </div>

            {{-- Filter Jadwal --}}
            <select name="jadwal" class="bk-select">
                <option value="">Semua Jadwal</option>
                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id_jadwal }}"
                        {{ request('jadwal') == $jadwal->id_jadwal ? 'selected' : '' }}>
                        {{ $jadwal->hari_label }} — {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                    </option>
                @endforeach
            </select>

            {{-- Filter Status --}}
            <select name="status" class="bk-select">
                <option value="">Semua Status</option>
                <option value="booking"       {{ request('status') == 'booking'       ? 'selected' : '' }}>Booking</option>
                <option value="terkonfirmasi" {{ request('status') == 'terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi</option>
                <option value="hadir"         {{ request('status') == 'hadir'         ? 'selected' : '' }}>Hadir</option>
                <option value="selesai"       {{ request('status') == 'selesai'       ? 'selected' : '' }}>Selesai</option>
            </select>

            <button type="submit" class="btn-primary">
                <i class="fas fa-search"></i> Filter
            </button>

            @if(request('search') || request('jadwal') || request('status'))
                <a href="{{ route('admin.booking') }}" class="bk-reset-btn">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bk-table-wrap">
        @if($bookings->isEmpty())
            <div class="bk-empty">
                <i class="fas fa-calendar-times"></i>
                <p>Tidak ada data booking ditemukan.</p>
                @if(request('search') || request('jadwal') || request('status'))
                    <a href="{{ route('admin.booking') }}" class="btn-primary" style="margin-top:12px">
                        Lihat Semua Booking
                    </a>
                @endif
            </div>
        @else
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Peserta</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $i => $bk)
                    <tr>
                        <td class="bk-num">{{ $bookings->firstItem() + $i }}</td>
                        <td>
                            <span class="bk-kode">#{{ str_pad($bk->kode_booking, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <div class="bk-peserta">
                                <div class="bk-avatar">{{ strtoupper(substr($bk->nama, 0, 1)) }}</div>
                                <span>{{ $bk->nama }}</span>
                            </div>
                        </td>
                        <td class="bk-email">{{ $bk->email }}</td>
                        <td>{{ $bk->telephone }}</td>
                        <td>
                            @if($bk->jadwal)
                                <div class="bk-jadwal-cell">
                                    <span class="bk-hari-badge">{{ $bk->jadwal->hari_label }}</span>
                                    <span class="bk-jam">{{ \Carbon\Carbon::parse($bk->jadwal->jam_mulai)->format('H:i') }} WIB</span>
                                </div>
                            @else
                                <span class="bk-no-jadwal">—</span>
                            @endif
                        </td>

                        {{-- Status Badge + Dropdown --}}
                        <td>
                            <div class="bk-status-wrap">
                                <span class="bk-status-badge {{ $bk->status_info['class'] }}">
                                    {{ $bk->status_info['label'] }}
                                </span>
                                <button class="bk-status-arrow" onclick="toggleStatusMenu({{ $bk->kode_booking }})" title="Ubah Status">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="bk-status-menu" id="status-menu-{{ $bk->kode_booking }}">
                                    @foreach(\App\Models\Booking::STATUSES as $s)
                                        @if($s !== $bk->status)
                                            <form action="{{ route('admin.booking.status', $bk->kode_booking) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="{{ $s }}">
                                                <button type="submit" class="bk-status-option {{ 'status-' . $s }}">
                                                    {{ ucfirst($s) }}
                                                </button>
                                            </form>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="bk-actions">
                                <a href="{{ route('admin.booking.edit', $bk->kode_booking) }}"
                                   class="bk-btn-edit" title="Edit Booking">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button onclick="confirmDelete({{ $bk->kode_booking }}, '{{ addslashes($bk->nama) }}')"
                                        class="bk-btn-delete" title="Hapus Booking">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <form id="delete-form-{{ $bk->kode_booking }}"
                                      action="{{ route('admin.booking.destroy', $bk->kode_booking) }}"
                                      method="POST" style="display:none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Pagination --}}
    @if($bookings->hasPages())
    <div class="bk-pagination">
        <div class="bk-pag-info">
            Menampilkan {{ $bookings->firstItem() }}–{{ $bookings->lastItem() }}
            dari {{ $bookings->total() }} data
        </div>
        <div class="bk-pag-links">
            @if($bookings->onFirstPage())
                <span class="bk-pag-btn disabled"><i class="fas fa-chevron-left"></i></span>
            @else
                <a href="{{ $bookings->previousPageUrl() }}" class="bk-pag-btn"><i class="fas fa-chevron-left"></i></a>
            @endif

            @foreach($bookings->getUrlRange(1, $bookings->lastPage()) as $page => $url)
                @if($page == $bookings->currentPage())
                    <span class="bk-pag-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="bk-pag-btn">{{ $page }}</a>
                @endif
            @endforeach

            @if($bookings->hasMorePages())
                <a href="{{ $bookings->nextPageUrl() }}" class="bk-pag-btn"><i class="fas fa-chevron-right"></i></a>
            @else
                <span class="bk-pag-btn disabled"><i class="fas fa-chevron-right"></i></span>
            @endif
        </div>
    </div>
    @endif

</div>

{{-- Modal Konfirmasi Hapus --}}
<div id="modal-delete" class="bk-modal-overlay" onclick="closeModal()">
    <div class="bk-modal" onclick="event.stopPropagation()">
        <div class="bk-modal-icon"><i class="fas fa-trash-alt"></i></div>
        <h3 class="bk-modal-title">Hapus Booking?</h3>
        <p class="bk-modal-desc">
            Data booking atas nama <strong id="modal-nama"></strong>
            akan dihapus permanen dan tidak dapat dikembalikan.
        </p>
        <div class="bk-modal-actions">
            <button onclick="closeModal()" class="bk-modal-cancel">Batal</button>
            <button onclick="doDelete()" class="bk-modal-confirm">
                <i class="fas fa-trash-alt"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── Delete modal ──────────────────────────────────
    let targetFormId = null;

    function confirmDelete(id, nama) {
        targetFormId = id;
        document.getElementById('modal-nama').textContent = nama;
        document.getElementById('modal-delete').classList.add('show');
    }

    function closeModal() {
        document.getElementById('modal-delete').classList.remove('show');
        targetFormId = null;
    }

    function doDelete() {
        if (targetFormId) document.getElementById('delete-form-' + targetFormId).submit();
    }

    // ── Status dropdown ───────────────────────────────
    function toggleStatusMenu(id) {
        // tutup semua menu lain dulu
        document.querySelectorAll('.bk-status-menu.open').forEach(el => {
            if (el.id !== 'status-menu-' + id) el.classList.remove('open');
        });
        document.getElementById('status-menu-' + id).classList.toggle('open');
    }

    // Klik di luar → tutup semua status menu
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.bk-status-wrap')) {
            document.querySelectorAll('.bk-status-menu.open')
                    .forEach(el => el.classList.remove('open'));
        }
    });

    // Auto-dismiss flash
    setTimeout(() => {
        document.querySelectorAll('.alert-success, .alert-error')
                .forEach(el => el.style.opacity = '0');
    }, 4000);
</script>
@endpush