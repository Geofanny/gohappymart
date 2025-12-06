<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use App\Models\User;

class Toko extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'toko';
    protected $primaryKey = 'id_toko';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'logo',
        'gambar',
        'nama',
        'tagline',
        'no_hp',
        'email',
        'visi',
        'misi',
        'deskripsi',
        'alamat',
    ];

    /**
     * Relasi ke User
     * Satu Toko dibuat oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
