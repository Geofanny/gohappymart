<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Models\Pesanan;
use App\Models\ItemPengembalian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengembalian extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'pengembalian';
    protected $primaryKey = 'id_pengembalian';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'no_pengembalian',
        'alasan',
        'deskripsi',
        'solusi',
        'status',
        'no_resi_pengembalian',
        'no_resi_balasan',
        'tgl_pengajuan',
        'tgl_selesai',
    ];

    // Relasi ke Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    // Relasi ke ItemPengembalian (1:N)
    public function item()
    {
        return $this->hasMany(ItemPengembalian::class, 'id_pengembalian', 'id_pengembalian');
    }
}
