<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Produk;
use App\Models\Promo;
use App\Models\ProdukPromo;
use Illuminate\Support\Facades\DB;

class ProdukPromoFactory extends Factory
{
    protected $model = ProdukPromo::class;

    public function definition(): array
    {
        // 🔹 Ambil promo aktif pertama (atau promo pertama jika tidak ada yang aktif)
        $promo = Promo::where('status', 'Aktif')->first() ?? Promo::first();

        // 🔹 Ambil daftar id_produk yang sudah ada di tabel produk_promo
        $produkSudahPromoIds = DB::table('produk_promo')->pluck('id_produk')->toArray();

        // 🔹 Ambil nama produk yang sudah ada di promo (supaya nama duplikat juga dihindari)
        $produkSudahPromoNama = Produk::whereIn('id_produk', $produkSudahPromoIds)
            ->pluck('nama_produk')
            ->toArray();

        // 🔹 Ambil produk pertama yang belum ada di daftar id maupun nama
        $produkBelumPromo = Produk::whereNotIn('id_produk', $produkSudahPromoIds)
            ->whereNotIn('nama_produk', $produkSudahPromoNama)
            ->orderBy('nama_produk', 'asc')
            ->first();

        // 🔹 Fallback jika semua produk sudah terpakai
        if (!$produkBelumPromo) {
            $produkBelumPromo = Produk::orderBy('tgl_ditambahkan', 'desc')->first();
        }

        return [
            'id_promo' => $promo->id_promo,
            'id_produk' => $produkBelumPromo->id_produk,
        ];
    }
}
