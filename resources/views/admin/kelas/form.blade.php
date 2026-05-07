@extends('layouts.admin')

@php
    $isEdit = isset($item) && $item->exists;
@endphp

@section('title', ($isEdit ? 'Edit Kelas' : 'Tambah Kelas'))
@section('page-title', ($isEdit ? 'Edit Kelas' : 'Tambah Kelas'))

@section('styles')
    <link rel="stylesheet" href="/css/dashboard.css">
    <link rel="stylesheet" href="/css/booking.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .bk-edit-wrap {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="bk-edit-wrap">
            <a href="{{ route('admin.kelas') }}" class="bk-back-link"><i class="fas fa-chevron-left"></i> Kembali ke daftar
                kelas</a>
            <div class="bk-edit-panel card bk-edit-panel">
                <div class="bk-edit-body card-body">
                    <form action="{{ $isEdit ? route('admin.kelas.update', $item->id_kelas) : route('admin.kelas.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($isEdit)
                            @method('PUT')
                        @endif

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-image"></i> Gambar</label>
                            @if($isEdit && $item->foto)
                                <div class="mb-2">
                                    <img src="{{ url('uploads/kelas/' . $item->foto) }}" alt=""
                                        style="max-height:160px; border-radius:10px;" />
                                </div>
                            @endif
                            <input type="file" name="foto" class="bk-input">
                            @error('foto') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-heading"></i> Nama Yoga</label>
                            <input type="text" name="nama_kelas" class="bk-input" value="{{ old('nama_kelas', $item->nama_kelas ?? '') }}"
                                required>
                            @error('nama_kelas') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-align-left"></i> Keterangan</label>
                            <textarea name="deskripsi" class="bk-input" rows="5"
                                required>{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
                            @error('deskripsi') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-chalkboard-teacher"></i> Nama Instruktur</label>
                            <input type="text" name="instruktur" class="bk-input"
                                value="{{ old('instruktur', $item->instruktur ?? '') }}" required>
                            @error('instruktur') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-money-bill-wave"></i> Harga</label>
                            <input type="number" step="0.01" name="biaya" class="bk-input"
                                value="{{ old('biaya', $item->biaya ?? 0) }}" required>
                            @error('biaya') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="bk-field">
                            <label class="bk-label"><i class="fas fa-users"></i> Kuota (per kelas)</label>
                            <input type="number" name="kuota" class="bk-input" value="{{ old('kuota', $item->kuota ?? 0) }}"
                                min="0">
                            @error('kuota') <div class="bk-field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="bk-edit-actions">
                            <button class="btn btn-primary">{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Kelas' }}</button>
                            <a href="{{ route('admin.kelas') }}" class="bk-btn-cancel">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endpush