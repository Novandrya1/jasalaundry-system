<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function transaksiKurir()
    {
        return $this->hasMany(Transaksi::class, 'kurir_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPelanggan()
    {
        return $this->role === 'pelanggan';
    }

    public function isKurir()
    {
        return $this->role === 'kurir';
    }
}
