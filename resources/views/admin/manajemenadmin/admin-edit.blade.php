@extends('layouts.admin')

@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
    .bk-edit-wrap {
        max-width: 520px;
        margin: 0 auto;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="bk-edit-wrap">
        <div class="panel">
    <div class="panel-header">
        <span class="panel-title">Edit Admin: {{ $admin->nama_user }}</span>
        <a href="{{ route('admin.manage-admin') }}" class="panel-action">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="panel-body" style="padding:24px;">

        @if($errors->any())
            <div class="alert-error" style="margin-bottom:20px;">
                <i class="fas fa-exclamation-circle"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul style="margin:8px 0 0 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.admin.update', $admin->id_user) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_user"
                       class="form-control @error('nama_user') is-invalid @enderror"
                       placeholder="Masukkan nama lengkap"
                       value="{{ old('nama_user', $admin->nama_user) }}" maxlength="35" required>
                @error('nama_user')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Username --}}
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username"
                       class="form-control @error('username') is-invalid @enderror"
                       placeholder="Username untuk login"
                       value="{{ old('username', $admin->username) }}" maxlength="25" required>
                @error('username')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Role --}}
            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" @selected(old('role', $admin->role) === 'admin')>Admin</option>
                    <option value="superadmin" @selected(old('role', $admin->role) === 'superadmin')>Super Admin</option>
                </select>
                @error('role')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="aktif"    @selected(old('status', $admin->status) === 'aktif')>Aktif</option>
                    <option value="tidak aktif" @selected(old('status', $admin->status) === 'tidak aktif') {{-- FIX: sesuai ENUM di tabel users --}}>Nonaktif</option>
                </select>
                @error('status')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Ganti Password (opsional) --}}
            <div style="border-top:1px solid #f0ede8; margin:20px 0; padding-top:20px;">
                <p style="font-size:13px; color:#888; margin:0 0 16px;">
                    <i class="fas fa-lock"></i>
                    Ganti Password <span style="font-weight:400;">(kosongkan jika tidak ingin mengubah)</span>
                </p>

                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="Ulangi password baru">
                </div>
            </div>

            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="btn-primary" style="flex:1;">
                    <i class="fas fa-save"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.manage-admin') }}"
                   class="bk-btn-cancel" style="flex:1; text-align:center; text-decoration:none;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
    </div>
</div>

@endsection