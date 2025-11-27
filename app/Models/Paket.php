<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_paket',
        'harga_per_kg',
        'deskripsi',
        'satuan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'harga_per_kg' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    // Relasi
    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    // Scope
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
