<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produk;
use App\Traits\HasUuid;
use App\Models\ProdukPromo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promo extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'promo';
    protected $primaryKey = 'id_promo';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nama_promo',
        'tipe',
        'nilai_diskon',
        'tgl_mulai',
        'tgl_selesai',
        'status',
        'banner',
        'kategori',
    ];

    /**
     * Relasi ke model User (1 User mengelola banyak Promo)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Promo.php
    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'produk_promo', 'id_promo', 'id_produk')
                    ->using(ProdukPromo::class);
    }
}
