<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'promo_id',
        'kode_promo',
        'status',
        'is_used',
        'approved_at',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'is_used' => 'boolean',
            'approved_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public static function generateKodePromo()
    {
        return 'PROMO' . strtoupper(substr(md5(uniqid()), 0, 6));
    }
}
