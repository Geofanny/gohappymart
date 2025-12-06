<?php

namespace App\Models;

use App\Models\Toko;
use App\Models\Promo;
use App\Models\Berita;
use App\Traits\HasUuid;
use App\Models\Regulasi;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuid;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'status',
        'tgl_buat'
    ];

    // Relasi
    public function berita()
    {
        return $this->hasMany(Berita::class, 'id_user', 'id_user');
    }

    public function regulasi()
    {
        return $this->hasMany(Regulasi::class, 'id_user', 'id_user');
    }

    public function toko()
    {
        return $this->hasOne(Toko::class, 'id_user', 'id_user');
    }

    public function promos()
    {
        return $this->hasMany(Promo::class, 'id_user', 'id_user');
    }
}