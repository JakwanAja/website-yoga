@extends('layouts.admin')

@section('title', 'Edit Booking')
@section('page-title', 'Edit Booking')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endsection

@section('content')

<div class="bk-edit-wrap">

    {{-- Breadcrumb back --}}
    <a href="{{ route('admin.booking') }}" class="bk-back-link">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Booking
    </a>

    <div class="panel bk-edit-panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-pen" style="color:var(--primary);margin-right:8px;font-size:15px"></i>
                Edit Booking
                <span class="bk-kode" style="margin-left:10px">
                    #{{ str_pad($booking->kode_booking, 4, '0', STR_PAD_LEFT) }}
                </span>
            </div>
        </div>

        <div class="bk-edit-body">
            <form action="{{ route('admin.booking.update', $booking->kode_booking) }}"
                  method="POST" id="edit-form">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="bk-field">
                    <label class="bk-label">
                        <i class="fas fa-user"></i> Nama Peserta
                    </label>
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama', $booking->nama) }}"
                        class="bk-input @error('nama') bk-input-error @enderror"
                        placeholder="Masukkan nama peserta"
                        maxlength="35"
                    >
                    @error('nama')
                        <span class="bk-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="bk-field">
                    <label class="bk-label">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $booking->email) }}"
                        class="bk-input @error('email') bk-input-error @enderror"
                        placeholder="contoh@email.com"
                        maxlength="35"
                    >
                    @error('email')
                        <span class="bk-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Telepon --}}
                <div class="bk-field">
                    <label class="bk-label">
                        <i class="fas fa-phone"></i> Nomor Telepon
                    </label>
                    <input
                        type="text"
                        name="telephone"
                        value="{{ old('telephone', $booking->telephone) }}"
                        class="bk-input @error('telephone') bk-input-error @enderror"
                        placeholder="08xxxxxxxxxx"
                        maxlength="13"
                    >
                    @error('telephone')
                        <span class="bk-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Jadwal --}}
                <div class="bk-field">
                    <label class="bk-label">
                        <i class="fas fa-clock"></i> Jadwal Kelas
                    </label>
                    <select
                        name="id_jadwal"
                        class="bk-input bk-select-field @error('id_jadwal') bk-input-error @enderror"
                    >
                        <option value="">— Pilih Jadwal —</option>
                        @foreach($jadwals as $jadwal)
                            <option
                                value="{{ $jadwal->id_jadwal }}"
                                {{ old('id_jadwal', $booking->id_jadwal) == $jadwal->id_jadwal ? 'selected' : '' }}
                            >
                                {{ $jadwal->hari_label }} —
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} WIB
                            </option>
                        @endforeach
                    </select>
                    @error('id_jadwal')
                        <span class="bk-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="bk-edit-actions">
                    <a href="{{ route('admin.booking') }}" class="bk-btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Highlight changed field
    document.querySelectorAll('.bk-input').forEach(input => {
        const original = input.value;
        input.addEventListener('input', () => {
            input.classList.toggle('bk-input-changed', input.value !== original);
        });
    });
</script>
@endpush