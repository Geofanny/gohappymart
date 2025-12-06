<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Kategori;

class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition(): array
    {
        static $index = 0;

        $kategori = [
            'CHEMICAL LAUNDRY',
            'ANTI NODA',
            'CAIRAN KEBERSIHAN R',
            'PLASTIK LAUNDRY',
            'AKSESORIS LAUNDRY',
            'HANGER',
            'PERLENGKAPAN LAUNDRY',
            'BOTOL',
            'BAHAN BAKU'
        ];

        return [
            'id_kategori' => (string) Str::uuid(),
            'kode' => 'KTG-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
            'nama' => $kategori[$index++ % count($kategori)],
        ];
    }
}
