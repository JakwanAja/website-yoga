@extends('layouts.admin')

@section('title', 'Kelola Admin')
@section('page-title', 'Kelola Admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
@endsection

@section('content')

<div class="panel">
    <div class="panel-header">
        <span class="panel-title">Daftar Admin</span>
        <a href="{{ route('admin.admin.create') }}" class="btn-primary" style="text-decoration:none;">
            <i class="fas fa-plus"></i> Tambah Admin
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success" style="margin: 16px 24px 0;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error" style="margin: 16px 24px 0;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="table-wrapper" style="padding: 24px;">
        <table class="data-table" style="width:100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr>
                    <th style="padding: 12px 20px; text-align:left; font-size:12px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#888; background:#f9f6f4; border-bottom:1px solid #ede8e4;">#</th>
                    <th style="padding: 12px 20px; text-align:left; font-size:12px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#888; background:#f9f6f4; border-bottom:1px solid #ede8e4;">Nama</th>
                    <th style="padding: 12px 20px; text-align:left; font-size:12px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#888; background:#f9f6f4; border-bottom:1px solid #ede8e4;">Username</th>
                    <th style="padding: 12px 20px; text-align:left; font-size:12px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#888; background:#f9f6f4; border-bottom:1px solid #ede8e4;">Role</th>
                    <th style="padding: 12px 20px; text-align:left; font-size:12px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#888; background:#f9f6f4; border-bottom:1px solid #ede8e4;">Status</th>
                    <th style="padding: 12px 20px; text-align:left; font-size:12px; font-weight:600; letter-spacing:.06em; text-transform:uppercase; color:#888; background:#f9f6f4; border-bottom:1px solid #ede8e4;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $i => $admin)
                <tr style="border-bottom: 1px solid #f0ebe7;">
                    <td style="padding: 18px 20px; color: #6b5c54; font-size:14px;">{{ $i + 1 }}</td>
                    <td style="padding: 18px 20px; color: #3b2a24; font-size:14px; font-weight:500;">{{ $admin->nama_user }}</td>
                    <td style="padding: 18px 20px; color: #6b5c54; font-size:14px;">{{ $admin->username }}</td>
                    <td style="padding: 18px 20px;">
                        @if($admin->role === 'superadmin')
                            <span style="display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; background:#ede0f5; color:#6b2fa0;">Super Admin</span>
                        @else
                            <span style="display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; background:#deeaf7; color:#2563a8;">Admin</span>
                        @endif
                    </td>
                    <td style="padding: 18px 20px;">
                        @if($admin->status === 'aktif')
                            <span style="display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; background:#d4f0e0; color:#1a7a45;">Aktif</span>
                        @else
                            <span style="display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; background:#fde8e8; color:#b91c1c;">Nonaktif</span>
                        @endif
                    </td>
                    <td style="padding: 18px 20px;">
                        <div style="display:flex; gap:8px; align-items:center;">
                            <a href="{{ route('admin.admin.edit', $admin->id_user) }}"
                               style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:10px; background:#8a6a5e; color:#fff; text-decoration:none; font-size:14px; transition:opacity .2s;"
                               title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            @if($admin->id_user !== auth()->id())
                            <form action="{{ route('admin.admin.destroy', $admin->id_user) }}"
                                  method="POST" style="display:inline;"
                                  onsubmit="return confirm('Yakin hapus admin {{ addslashes($admin->nama_user) }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:10px; background:#c0392b; color:#fff; border:none; cursor:pointer; font-size:14px; transition:opacity .2s;"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @else
                            <span style="font-size:12px; color:#aaa; padding: 0 4px;">(Anda)</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:56px 20px; color:#bbb;">
                        <i class="fas fa-users" style="font-size:28px; opacity:0.3; display:block; margin-bottom:10px;"></i>
                        Belum ada admin terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush