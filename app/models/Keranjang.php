<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Models\Pelanggan;
use App\Models\KeranjangProduk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keranjang extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false; // karena tidak ada created_at / updated_at

    protected $fillable = [
        'id_pelanggan',
    ];

    // Relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // Relasi ke keranjang_produk
    public function produk()
    {
        return $this->hasMany(KeranjangProduk::class, 'id_keranjang', 'id_keranjang');
    }
}
