<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    public $timestamps = false; // ← tambahkan ini

    protected $fillable = [
        'foto',
        'nama_kelas',
        'deskripsi',
        'instruktur',
        'kuota',   
        'biaya',
    ];

    public function getBiayaRpAttribute(): string
    {
        return 'Rp ' . number_format($this->biaya, 0, ',', '.');
    }
}