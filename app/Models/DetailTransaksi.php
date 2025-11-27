<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'paket_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'decimal:2',
            'harga_satuan' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    // Relasi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    // Observer untuk menghitung subtotal otomatis
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detail) {
            $detail->subtotal = $detail->jumlah * $detail->harga_satuan;
        });
    }
}
