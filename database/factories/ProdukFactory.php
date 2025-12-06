<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Produk;
use App\Models\Kategori;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition(): array
    {
        $produkList = [
            // === CHEMICAL LAUNDRY ===
            ['nama' => 'Deterjen Philux 5 Liter', 'jenis' => 'CHEMICAL LAUNDRY', 'berat' => '5L'],
            ['nama' => 'Softener Freshblue 5 Liter', 'jenis' => 'CHEMICAL LAUNDRY', 'berat' => '5L'],
            ['nama' => 'Parfum Laundry Grade A 1L Akasia', 'jenis' => 'CHEMICAL LAUNDRY', 'berat' => '1L'],
            ['nama' => 'Parfum Laundry Grade SUPER 5L Premium Philux', 'jenis' => 'CHEMICAL LAUNDRY', 'berat' => '5L'],
            ['nama' => 'Galawangi Lovely 1 Liter', 'jenis' => 'CHEMICAL LAUNDRY', 'berat' => '1L'],
            ['nama' => 'ASTONISH Dry Clean', 'jenis' => 'CHEMICAL LAUNDRY', 'berat' => '1L'],

            // === ANTI NODA ===
            ['nama' => 'Stainwash Anti Noda Tinta 250ml', 'jenis' => 'ANTI NODA', 'berat' => '250ml'],
            ['nama' => 'BRITO 100ml Anti Noda Karat', 'jenis' => 'ANTI NODA', 'berat' => '100ml'],
            ['nama' => 'Serbuk Ajaib Ultra Putih 500gr', 'jenis' => 'ANTI NODA', 'berat' => '500gr'],
            ['nama' => 'Oxy Bubuk 1 Kg', 'jenis' => 'ANTI NODA', 'berat' => '1kg'],

            // === CAIRAN KEBERSIHAN R ===
            ['nama' => 'Pembersih Lantai Lavender 5 Liter', 'jenis' => 'CAIRAN KEBERSIHAN R', 'berat' => '5L'],
            ['nama' => 'Shampoo Karpet 5 Liter', 'jenis' => 'CAIRAN KEBERSIHAN R', 'berat' => '5L'],
            ['nama' => 'Handsoap Strawberry 5 Liter', 'jenis' => 'CAIRAN KEBERSIHAN R', 'berat' => '5L'],

            // === PLASTIK LAUNDRY ===
            ['nama' => 'Plastik Jinjing 3 Jari Polos Uk. 40', 'jenis' => 'PLASTIK LAUNDRY', 'berat' => '500gr'],
            ['nama' => 'Plastik Satuan Sablon Premium Gold 60x100', 'jenis' => 'PLASTIK LAUNDRY', 'berat' => '300gr'],
            ['nama' => 'Plastik Laundry Kiloan Uk. 50x75', 'jenis' => 'PLASTIK LAUNDRY', 'berat' => '1kg'],

            // === AKSESORIS LAUNDRY ===
            ['nama' => 'Silica Gel Natural 5 Gram', 'jenis' => 'AKSESORIS LAUNDRY', 'berat' => '5gr'],
            ['nama' => 'Lakban NG Tape 48mm', 'jenis' => 'AKSESORIS LAUNDRY', 'berat' => '48mm'],
            ['nama' => 'Selang Setrika Grade A', 'jenis' => 'AKSESORIS LAUNDRY', 'berat' => '1kg'],

            // === HANGER ===
            ['nama' => 'Hanger Plastik Standard 41cm', 'jenis' => 'HANGER', 'berat' => '200gr'],
            ['nama' => 'Hanger Kawat Putih 18 Inch', 'jenis' => 'HANGER', 'berat' => '300gr'],

            // === PERLENGKAPAN LAUNDRY ===
            ['nama' => 'Keranjang Laundry Hitam', 'jenis' => 'PERLENGKAPAN LAUNDRY', 'berat' => '2kg'],
            ['nama' => 'Alas Busa Komplit 120x60', 'jenis' => 'PERLENGKAPAN LAUNDRY', 'berat' => '3kg'],

            // === BOTOL / KEMASAN ===
            ['nama' => 'Botol Spray 250ml', 'jenis' => 'BOTOL', 'berat' => '250ml'],
            ['nama' => 'Jerigen 5 Liter', 'jenis' => 'BOTOL', 'berat' => '5L'],
            ['nama' => 'Kantong Kresek PE Uk. 40', 'jenis' => 'BOTOL', 'berat' => '500gr'],

            // === BAHAN BAKU ===
            ['nama' => 'Bibit 1 Liter Premium Philux', 'jenis' => 'BAHAN BAKU', 'berat' => '1L'],
            ['nama' => 'Fixative Galaxolide 250ml', 'jenis' => 'BAHAN BAKU', 'berat' => '250ml'],
            ['nama' => 'CITRUN 1 Kg', 'jenis' => 'BAHAN BAKU', 'berat' => '1kg'],
        ];

        // mapping kategori → gambar
        $gambarMapping = [
            'CHEMICAL LAUNDRY' => 'chemical.jpg',
            'ANTI NODA' => 'anti.jpeg',
            'CAIRAN KEBERSIHAN R' => 'pembersih.jpg',
            'PLASTIK LAUNDRY' => 'plastik.jpg',
            'AKSESORIS LAUNDRY' => 'akses.jpg',
            'HANGER' => 'hanger.png',
            'PERLENGKAPAN LAUNDRY' => 'perlengkap.jpeg',
            'BOTOL' => 'botol.jpg',
            'BAHAN BAKU' => 'bahan.jpg',
        ];

        $produk = collect($produkList)->random();
        $kategori = Kategori::where('nama', $produk['jenis'])->first() ?? Kategori::inRandomOrder()->first();
        $gambar = $gambarMapping[$produk['jenis']] ?? 'default.jpg';

        $deskripsi = "{$produk['nama']} adalah produk kategori {$produk['jenis']} dengan berat netto {$produk['berat']}.";

        return [
            'id_produk' => (string) Str::uuid(),
            'id_kategori' => $kategori->id_kategori,
            'sku' => strtoupper('SKU-' . Str::random(6)),
            'nama_produk' => $produk['nama'],
            'deskripsi' => $deskripsi,
            'harga' => fake()->numberBetween(20000, 500000),
            'stok' => fake()->numberBetween(10, 200),
            'gambar' => $gambar,
            'status' => fake()->randomElement(['aktif', 'nonaktif']),
            'tgl_ditambahkan' => now(),
        ];
    }
}
