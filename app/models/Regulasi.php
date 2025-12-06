<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use App\Models\User;

class Regulasi extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'regulasi';
    protected $primaryKey = 'id_regulasi';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $with =  ['user'];

    protected $fillable = [
        'id_user',
        'jenis',
        'judul',
        'isi',
        'tgl_publikasi',
    ];

    /**
     * Relasi ke User
     * Setiap Regulasi dibuat oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
