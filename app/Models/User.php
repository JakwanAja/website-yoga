<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_user';
    public $incrementing = true;        
    protected $keyType = 'int';    

    protected $fillable = [
        'nama_user',
        'username',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        // status disimpan sebagai string ENUM ('aktif'/'nonaktif'), bukan boolean
        'status' => 'string',
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

    public function setStatus(int $status): void
    {
        $this->status = $status;
        $this->saveQuietly();
    }
}