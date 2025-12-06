<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Models\Pengembalian;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemPengembalian extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'item_pengembalian';
    protected $primaryKey = 'id_item';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_pengembalian',
        'id_produk',
    ];

    // Relasi ke Pengembalian (N:1)
    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian', 'id_pengembalian');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    
}
