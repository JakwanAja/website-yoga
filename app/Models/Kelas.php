<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'gambar',
        'nama',
        'keterangan',
        'instruktur',
        'harga',
        'kuota',
    ];

    /**
     * Format harga sebagai string currency
     */
    public function getHargaRpAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
