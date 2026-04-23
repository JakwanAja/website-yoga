<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    protected $table = 'jadwal_kelas';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    protected $fillable = [
        'hari',
        'jam_mulai',
        'status',
        'booking_id_booking',
    ];

    /**
     * Label hari dalam Bahasa Indonesia
     */
    public function getHariLabelAttribute(): string
    {
        return ucfirst($this->hari);
    }

    /**
     * Label status: 1 = Aktif, 0 = Nonaktif
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Aktif' : 'Nonaktif';
    }

    /**
     * Relasi balik ke Booking
     */
    public function booking()
    {
        return $this->hasMany(Booking::class, 'id_jadwal', 'id_jadwal');
    }
}