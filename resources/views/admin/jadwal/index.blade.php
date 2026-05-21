@extends('layouts.admin')

@section('title', 'Manajemen Jadwal')
@section('page-title', 'Manajemen Jadwal')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('content')

<div class="panel" style="margin-bottom: 20px;">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-clock" style="color:var(--primary); margin-right:8px;"></i>Ringkasan Jadwal
        </div>
        <a href="{{ route('admin.jadwal.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Jadwal
        </a>
    </div>
    <div class="panel-body" style="padding: 24px;">
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Total Jadwal</div>
                <div class="summary-value">{{ $total }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Kelas Terjadwal</div>
                <div class="summary-value">{{ $jadwals->count() }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Hari Terbanyak</div>
                <div class="summary-value">{{ $jadwals->groupBy('hari')->keys()->count() }}</div>
            </div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <span class="panel-title">Daftar Jadwal Yoga</span>
        <a href="{{ route('admin.jadwal.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Jadwal
        </a>
    </div>

    <div class="panel-body">
        @if($jadwals->isEmpty())
            <div class="bk-empty">
                <i class="fas fa-database"></i>
                <p>Tidak ada jadwal yoga ditemukan.</p>
            </div>
        @else
            <table class="booking-table" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Yoga</th>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Sisa Kuota</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwals as $jadwal)
                    <tr>
                        <td>{{ $jadwal->id_jadwal }}</td>
                        <td>{{ $jadwal->kelas?->nama_kelas ?? '–' }}</td>
                        <td>{{ $jadwal->hari_label }}</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} WIB</td>
                        <td>{{ $jadwal->sisa_kuota ?? '–' }}</td>
                        <td>
                            <div class="bk-actions">
                                <a href="{{ route('admin.jadwal.edit', $jadwal->id_jadwal) }}"
                                   class="bk-btn-edit" title="Edit Jadwal">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button onclick="confirmDelete({{ $jadwal->id_jadwal }}, '{{ addslashes($jadwal->kelas?->nama_kelas ?? 'jadwal ini') }}')"
                                        class="bk-btn-delete" title="Hapus Jadwal">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <form id="delete-form-{{ $jadwal->id_jadwal }}"
                                      action="{{ route('admin.jadwal.destroy', $jadwal->id_jadwal) }}"
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

            <div style="margin-top:16px; display:flex; justify-content:flex-end;">
                {{ $jadwals->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div id="modal-delete" class="bk-modal-overlay" onclick="closeModal()">
    <div class="bk-modal" onclick="event.stopPropagation()">
        <div class="bk-modal-icon"><i class="fas fa-trash-alt"></i></div>
        <h3 class="bk-modal-title">Hapus Jadwal?</h3>
        <p class="bk-modal-desc">
            Jadwal kelas <strong id="modal-nama"></strong>
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

    // Auto-dismiss flash
    setTimeout(() => {
        document.querySelectorAll('.alert-success, .alert-error')
                .forEach(el => el.style.opacity = '0');
    }, 4000);
</script>
@endpush