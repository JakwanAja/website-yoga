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
        'kuota',
        'booking_id_booking',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function getHariLabelAttribute(): string
    {
        return ucfirst($this->hari);
    }
}
