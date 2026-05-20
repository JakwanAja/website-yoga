@extends('layouts.admin')

@section('title', $item->exists ? 'Edit Jadwal' : 'Tambah Jadwal')
@section('page-title', $item->exists ? 'Edit Jadwal' : 'Tambah Jadwal')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="panel">
    <div class="panel-header">
        <span class="panel-title">{{ $item->exists ? 'Edit Jadwal Yoga' : 'Tambah Jadwal Yoga' }}</span>
        <a href="{{ route('admin.jadwal') }}" class="panel-action">Kembali ke daftar</a>
    </div>

    <div class="panel-body" style="padding: 24px;">
        @if($errors->any())
            <div class="alert-error" style="margin-bottom:20px;">
                <strong>Terdapat kesalahan input:</strong>
                <ul style="margin-top:10px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $item->exists ? route('admin.jadwal.update', $item->id_jadwal) : route('admin.jadwal.store') }}" method="POST">
            @csrf
            @if($item->exists)
                @method('PUT')
            @endif

            @if($kelasOptions->isEmpty())
                <div class="alert-error" style="margin-bottom:16px;">
                    Belum ada kelas yoga yang tersedia. Silakan tambah kelas terlebih dahulu melalui menu "Kelas".
                </div>
            @endif

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Yoga</label>
                    <select name="kelas_id" class="form-control" required {{ $kelasOptions->isEmpty() ? 'disabled' : '' }}>
                        <option value="">Pilih kelas yoga</option>
                        @foreach($kelasOptions as $kelas)
                            <option value="{{ $kelas->id_kelas }}" {{ old('kelas_id', $item->kelas_id) == $kelas->id_kelas ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Hari</label>
                    <select name="hari" class="form-control" required>
                        <option value="">Pilih hari</option>
                        @foreach($hariOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('hari', $item->hari) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control"
                        value="{{ old('jam_mulai', $item->jam_mulai) }}" required>
                </div>

                {{--
                    FIX: Field kuota dihapus dari form jadwal.
                    Sisa kuota (sisa_kuota) diisi otomatis dari kuota kelas saat jadwal dibuat,
                    dan berkurang sendiri setiap ada booking masuk — tidak perlu input manual.
                --}}
                @if($item->exists)
                    <div class="form-group">
                        <label>Sisa Kuota</label>
                        <input type="text" class="form-control"
                            value="{{ $item->sisa_kuota ?? '—' }}" disabled
                            style="background:#f5f5f5; color:#888; cursor:not-allowed;">
                        <small style="font-size:0.8rem; color:#888;">
                            Diisi otomatis dari kuota kelas. Berkurang setiap ada booking masuk.
                        </small>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn-primary" style="margin-top:16px;"
                {{ $kelasOptions->isEmpty() ? 'disabled' : '' }}>
                <i class="fas fa-save"></i>
                {{ $item->exists ? 'Perbarui Jadwal' : 'Simpan Jadwal' }}
            </button>
        </form>
    </div>
</div>
@endsection