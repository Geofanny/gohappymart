<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'no_pembayaran',
        'metode',
        'status',
        'jumlah',
        'tgl_pembayaran'
    ];

    // Relasi ke Pesanan (banyak pembayaran → 1 pesanan)
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
