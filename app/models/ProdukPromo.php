<?php

namespace App\Models;

use App\Models\Promo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukPromo extends Pivot
{
    use HasFactory;
    protected $table = 'produk_promo';

    // Jika pakai UUID dan ingin mass assignable
    protected $fillable = ['id_produk', 'id_promo'];

    // Disable incrementing karena primary key gabungan
    public $incrementing = false;

    // Tipe primary key UUID
    protected $keyType = 'string';

    // Jika ingin timestamps
    public $timestamps = false; // set true kalau pakai created_at / updated_at

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'id_promo', 'id_promo');
    }

}
