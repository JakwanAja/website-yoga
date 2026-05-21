@extends('layouts.admin')

@section('title', 'Kelola Admin')
@section('page-title', 'Kelola Admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('content')

<div class="panel">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-users-cog" style="color:var(--primary);margin-right:8px;font-size:16px"></i>
            Daftar Admin
        </div>
        <a href="{{ route('admin.admin.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Admin
        </a>
    </div>

    <div class="bk-table-wrap">
        @if($admins->isEmpty())
            <div class="bk-empty">
                <i class="fas fa-users"></i>
                <p>Belum ada admin terdaftar.</p>
            </div>
        @else
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $i => $admin)
                    <tr>
                        <td class="bk-num">{{ $i + 1 }}</td>
                        <td>
                            <div class="bk-peserta">
                                <div class="bk-avatar">{{ strtoupper(substr($admin->nama_user, 0, 1)) }}</div>
                                <span>{{ $admin->nama_user }}</span>
                            </div>
                        </td>
                        <td class="bk-email">{{ $admin->username }}</td>
                        <td>
                            @if($admin->role === 'superadmin')
                                <span class="bk-status-badge status-terkonfirmasi">Super Admin</span>
                            @else
                                <span class="bk-status-badge status-hadir">Admin</span>
                            @endif
                        </td>
                        <td>
                            @if($admin->status === 'aktif')
                                <span class="bk-status-badge status-hadir">Aktif</span>
                            @else
                                <span class="bk-status-badge status-booking">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="bk-actions">
                                <a href="{{ route('admin.admin.edit', $admin->id_user) }}"
                                   class="bk-btn-edit" title="Edit Admin">
                                    <i class="fas fa-pen"></i>
                                </a>
                                @if($admin->id_user !== auth()->id())
                                    <button onclick="confirmDelete({{ $admin->id_user }}, '{{ addslashes($admin->nama_user) }}')"
                                            class="bk-btn-delete" title="Hapus Admin">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <form id="delete-form-{{ $admin->id_user }}"
                                          action="{{ route('admin.admin.destroy', $admin->id_user) }}"
                                          method="POST" style="display:none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @else
                                    <span style="font-size:12px;color:var(--text-muted);padding:0 4px;">(Anda)</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div id="modal-delete" class="bk-modal-overlay" onclick="closeModal()">
    <div class="bk-modal" onclick="event.stopPropagation()">
        <div class="bk-modal-icon"><i class="fas fa-trash-alt"></i></div>
        <h3 class="bk-modal-title">Hapus Admin?</h3>
        <p class="bk-modal-desc">
            Akun admin <strong id="modal-nama"></strong>
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