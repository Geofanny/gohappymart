<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Models\Wishlist;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // penting

class Pelanggan extends Authenticatable
{
    use HasFactory, HasUuid, Notifiable;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nama_pelanggan',
        'username',
        'email',
        'no_hp',
        'tgl_buat',
        'password',
        'jk',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'id_pelanggan', 'id_pelanggan');
    }
}
