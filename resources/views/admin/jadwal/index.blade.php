@extends('layouts.admin')

@section('title', 'Manajemen Jadwal')
@section('page-title', 'Manajemen Jadwal')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')

<div class="panel" style="margin-bottom: 20px;">
    <div class="panel-header">
        <div class="panel-title"><i class="fas fa-clock" style="color:var(--primary); margin-right:8px;"></i>Ringkasan Jadwal</div>
        <a href="{{ route('admin.jadwal.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah Jadwal</a>
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
        <a href="{{ route('admin.jadwal.create') }}" class="btn-primary"><i class="fas fa-plus"></i> Tambah Kelas</a>
    </div>

    <div class="panel-body">
        @if($jadwals->isEmpty())
            <div style="padding: 40px; text-align:center; color:var(--text-muted);">
                <i class="fas fa-database" style="font-size:36px; margin-bottom:16px; display:block; opacity:0.35;"></i>
                Tidak ada jadwal yoga ditemukan.
            </div>
        @else
            <table class="booking-table" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Yoga</th>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Kuota</th>
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
                        <td>{{ $jadwal->kuota ?? '–' }}</td>
                        <td>
                            <a href="{{ route('admin.jadwal.edit', $jadwal->id_jadwal) }}" class="btn-primary" style="padding:8px 14px; font-size:13px;">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.jadwal.destroy', $jadwal->id_jadwal) }}" method="POST" style="display:inline-block; margin-left:8px;" onsubmit="return confirm('Hapus jadwal {{ addslashes($jadwal->kelas?->nama_kelas ?? 'jadwal ini') }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-primary" style="background:#d9534f; border:none;"> <i class="fas fa-trash-alt"></i> </button>
                            </form>
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

@endsection