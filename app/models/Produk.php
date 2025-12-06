<?php

namespace App\Models;

use App\Models\Promo;
use App\Models\Ulasan;
use App\Traits\HasUuid;
use App\Models\Kategori;
use App\Models\Wishlist;
use App\Models\ProdukPromo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false; // karena kita pakai tgl_ditambahkan sendiri

    protected $with = ['kategori','promos'];
    protected $fillable = [
        'id_kategori',
        'sku',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'status',
        'tgl_ditambahkan',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // Produk.php
    public function promos()
    {
        return $this->belongsToMany(Promo::class, 'produk_promo', 'id_produk', 'id_promo')
                    ->using(ProdukPromo::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'id_produk', 'id_produk');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_produk', 'id_produk');
    }
}
