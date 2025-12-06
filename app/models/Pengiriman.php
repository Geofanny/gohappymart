<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengiriman extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'pengiriman';
    protected $primaryKey = 'id_pengiriman';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'status',
        'tgl_kirim',
        'tgl_selesai',
        'alamat',
        'jasa_kirim',
        'no_resi',
        'ongkir'
    ];

    // Relasi ke Pesanan (1:1)
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
