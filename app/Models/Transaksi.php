<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_invoice',
        'user_id',
        'kurir_id',
        'berat_aktual',
        'total_harga',
        'status_transaksi',
        'status_bayar',
        'metode_bayar',
        'bukti_transfer',
        'bank_info',
        'alamat_jemput',
        'catatan',
        'tanggal_jemput',
        'tanggal_proses_cuci',
        'tanggal_siap_antar',
        'tanggal_selesai',
        'promo_claim_id',
        'diskon',
    ];

    protected function casts(): array
    {
        return [
            'berat_aktual' => 'decimal:2',
            'total_harga' => 'decimal:2',
            'diskon' => 'decimal:2',
            'tanggal_jemput' => 'datetime',
            'tanggal_proses_cuci' => 'datetime',
            'tanggal_siap_antar' => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kurir()
    {
        return $this->belongsTo(User::class, 'kurir_id');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function promoClaim()
    {
        return $this->belongsTo(PromoClaim::class);
    }

    // Helper methods
    public static function generateKodeInvoice()
    {
        $date = Carbon::now()->format('Ymd');
        $lastInvoice = self::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();
        
        $number = $lastInvoice ? (int)substr($lastInvoice->kode_invoice, -4) + 1 : 1;
        
        return 'INV/' . $date . '/' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function hitungTotalHarga()
    {
        $subtotal = $this->detailTransaksis->sum('subtotal');
        $this->total_harga = $subtotal - $this->diskon;
        $this->save();
    }
}
