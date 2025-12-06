<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Promo;

class PromoFactory extends Factory
{
    protected $model = Promo::class;

    public function definition(): array
    {
        // ✅ Ambil user pertama (atau buat kalau belum ada)
        $user = User::first();

        // Daftar promo realistis
        $namaPromos = [
            'Promo Akhir Tahun',
            'Diskon Softener Spesial',
            'Cuci Kiloan Hemat',
            'Paket Parfum Laundry',
            'Promo Weekend Bersih-Bersih',
            'Diskon Deterjen',
            'Promo Ulang Tahun Toko',
            'Cuci Sprei Gratis Parfum',
            'Diskon Khusus Member Laundry',
            'Promo Hemat Bulanan',
        ];

        // Pilih promo acak dari daftar di atas
        $namaPromo = $this->faker->randomElement($namaPromos);

        // Tentukan tipe dan nilai diskon lebih logis
        $tipe = str_contains($namaPromo, '%') ? 'Persen' : $this->faker->randomElement(['Persen', 'Nominal']);
        $nilaiDiskon = $tipe === 'Persen'
            ? $this->faker->randomElement([5, 10, 15, 20, 25])
            : $this->faker->randomElement([5000, 10000, 15000, 20000]);

        // Range tanggal promo
        $tglMulai = $this->faker->dateTimeBetween('-1 month', 'now');
        $tglSelesai = (clone $tglMulai)->modify('+10 days');

        return [
            'id_promo' => (string) Str::uuid(),
            'id_user' => $user->id_user,
            'nama_promo' => $namaPromo,
            'tipe' => $tipe,
            'nilai_diskon' => $nilaiDiskon,
            'tgl_mulai' => $tglMulai,
            'tgl_selesai' => $tglSelesai,
            'status' => $this->faker->randomElement(['Aktif', 'Nonaktif']),
        ];
    }
}
