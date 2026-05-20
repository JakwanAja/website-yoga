@extends('layouts.admin')

@section('title', 'Tambah Admin')
@section('page-title', 'Tambah Admin')

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
        <a href="{{ route('admin.manage-admin') }}" class="bk-back-link">
            <i class="fas fa-chevron-left"></i> Kembali ke daftar admin
        </a>

        <div class="bk-edit-panel card">
            <div class="bk-edit-body card-body">

                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Terdapat kesalahan:</strong>
                        <ul style="margin: 8px 0 0 16px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.admin.store') }}" method="POST">
                    @csrf

                    {{-- Nama --}}
                    <div class="bk-field">
                        <label class="bk-label"><i class="fas fa-user"></i> Nama Lengkap</label>
                        <input type="text" name="nama_user"
                               class="bk-input @error('nama_user') is-invalid @enderror"
                               placeholder="Masukkan nama lengkap"
                               value="{{ old('nama_user') }}" maxlength="35" required>
                        @error('nama_user')
                            <div class="bk-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Username --}}
                    <div class="bk-field">
                        <label class="bk-label"><i class="fas fa-at"></i> Username</label>
                        <input type="text" name="username"
                               class="bk-input @error('username') is-invalid @enderror"
                               placeholder="Masukkan username untuk login"
                               value="{{ old('username') }}" maxlength="25" required>
                        @error('username')
                            <div class="bk-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="bk-field">
                        <label class="bk-label"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" name="password"
                               class="bk-input @error('password') is-invalid @enderror"
                               placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <div class="bk-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="bk-field">
                        <label class="bk-label"><i class="fas fa-lock"></i> Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                               class="bk-input"
                               placeholder="Ulangi password" required>
                    </div>

                    {{-- Role --}}
                    <div class="bk-field">
                        <label class="bk-label"><i class="fas fa-user-shield"></i> Role</label>
                        <select name="role" class="bk-input @error('role') is-invalid @enderror" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                            <option value="superadmin" @selected(old('role') === 'superadmin')>Super Admin</option>
                        </select>
                        @error('role')
                            <div class="bk-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="bk-edit-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Admin
                        </button>
                        <a href="{{ route('admin.manage-admin') }}" class="bk-btn-cancel">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush