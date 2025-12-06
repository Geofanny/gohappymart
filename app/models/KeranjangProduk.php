<?php

namespace App\Models;

use App\Models\Produk;
use App\Traits\HasUuid;
use App\Models\Keranjang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeranjangProduk extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'keranjang_produk';
    protected $primaryKey = 'id_keranjang_produk';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false; // karena pakai tgl_ditambahkan

    protected $fillable = [
        'id_keranjang',
        'id_produk',
        'jumlah',
        'tgl_ditambahkan',
    ];

    // Relasi ke keranjang
    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'id_keranjang', 'id_keranjang');
    }

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
