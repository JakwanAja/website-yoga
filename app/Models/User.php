<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Primary key sesuai skema database.
     */
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama_user',
        'username',
        'password',
        'role',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast tipe data kolom.
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    // ── Helper: cek role ──────────────────────────────────────

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /**
     * Ubah status user — hanya boleh dipanggil oleh superadmin.
     *
     * Contoh di controller:
     *   if (Auth::user()->isSuperAdmin()) {
     *       $user->setStatus(1);
     *   }
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
        $this->saveQuietly();
    }
}