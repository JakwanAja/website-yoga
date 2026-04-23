<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table      = 'booking';
    protected $primaryKey = 'kode_booking';
    public    $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'telephone',
        'id_jadwal',
        'status',
    ];

    /**
     * Daftar status yang valid (urutan alur)
     */
    const STATUSES = ['booking', 'terkonfirmasi', 'hadir', 'selesai'];

    /**
     * Label & class CSS untuk badge tiap status
     */
    public function getStatusInfoAttribute(): array
    {
        return match($this->status) {
            'booking'       => ['label' => 'Booking',       'class' => 'status-booking'],
            'terkonfirmasi' => ['label' => 'Terkonfirmasi', 'class' => 'status-terkonfirmasi'],
            'hadir'         => ['label' => 'Hadir',         'class' => 'status-hadir'],
            'selesai'       => ['label' => 'Selesai',       'class' => 'status-selesai'],
            default         => ['label' => 'Unknown',       'class' => ''],
        };
    }

    /**
     * Relasi ke jadwal_kelas
     */
    public function jadwal()
    {
        return $this->belongsTo(JadwalKelas::class, 'id_jadwal', 'id_jadwal');
    }
}