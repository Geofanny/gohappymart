<?php

namespace App\Models;

use App\Models\Pelanggan;
use App\Models\Produk;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'wishlist';
    protected $primaryKey = 'id_wishlist';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_pelanggan',
        'id_produk',
        'tgl_ditambahkan',
    ];

    // Relasi ke Pelanggan (setiap wishlist dimiliki oleh 1 pelanggan)
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // Relasi ke Produk (setiap wishlist berisi 1 produk)
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
