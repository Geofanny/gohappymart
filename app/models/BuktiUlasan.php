<?php

namespace App\Models;

use App\Models\Ulasan;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuktiUlasan extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'bukti_ulasan';
    protected $primaryKey = 'id_foto';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_ulasan',
        'nama_file',
    ];

    // Relasi ke Ulasan (N:1)
    public function ulasan()
    {
        return $this->belongsTo(Ulasan::class, 'id_ulasan', 'id_ulasan');
    }
}
