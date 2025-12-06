<?php

namespace App\Models;

use App\Models\Ulasan;
use App\Traits\HasUuid;
use App\Models\Pelanggan;
use App\Models\Pengiriman;
use App\Models\Pengembalian;
use App\Models\PesananProduk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false; // karena tgl_pesanan kita simpan manual

    protected $fillable = [
        'id_pelanggan',
        'tgl_pesanan',
        'status',
        'total_harga',
        'catatan',
        'no_pesanan',
        'alasan'
    ];

    // Relasi ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // Relasi ke PesananProduk
    public function produk()
    {
        return $this->hasMany(PesananProduk::class, 'id_pesanan', 'id_pesanan');
    }

    // Relasi ke Pengiriman (1:1)
    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'id_pesanan', 'id_pesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_pesanan', 'id_pesanan');
    }


    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class, 'id_pesanan', 'id_pesanan');
    }

}
