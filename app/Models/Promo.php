<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'diskon_persen',
        'diskon_nominal',
        'tipe_diskon',
        'gambar',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'diskon_persen' => 'decimal:2',
            'diskon_nominal' => 'decimal:2',
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function claims()
    {
        return $this->hasMany(PromoClaim::class);
    }

    public function getDiskonTextAttribute()
    {
        if ($this->tipe_diskon === 'persen') {
            return $this->diskon_persen . '%';
        }
        return 'Rp ' . number_format($this->diskon_nominal, 0, ',', '.');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('tanggal_mulai', '<=', Carbon::today())
                    ->where('tanggal_selesai', '>=', Carbon::today());
    }
}
