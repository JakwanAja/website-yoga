<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalModel extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kelas';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    protected $fillable = [
        'kelas_id',
        'hari',
        'jam_mulai',
        'status',
        'sisa_kuota',
        // 'booking_id_booking' ← dihapus, tidak ada di tabel
    ];
    protected $attributes = [
        'status' => 'aktif', // default otomatis saat create
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
        //                                               ↑ tambahkan foreign key yang benar
    }

    public function getHariLabelAttribute(): string
    {
        return ucfirst($this->hari);
    }
}