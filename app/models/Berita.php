<?php

namespace App\Models;

use App\Models\User;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $with =  ['user'];

    protected $fillable = [
        'id_user',
        'judul',
        'isi',
        'status',
        'gambar',
        'tgl',
        'pengunjung',
    ];

    // RELASI: Berita dimiliki oleh User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    protected $casts = [
        'tgl' => 'datetime',
    ];
}
