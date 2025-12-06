<?php

namespace App\Models;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Traits\HasUuid;
use App\Models\Pelanggan;
use App\Models\BuktiUlasan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ulasan extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false; // tabel tidak punya created_at & updated_at

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'id_pelanggan',
        'rating',
        'ulasan',
        'tipe',
        'tgl_ulasan',
        'balasan'
    ];

    // Relasi ke Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    // Relasi ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // Relasi ke BuktiUlasan (1 ulasan bisa punya banyak bukti)
    public function bukti()
    {
        return $this->hasMany(BuktiUlasan::class, 'id_ulasan', 'id_ulasan');
    }
}
