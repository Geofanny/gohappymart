<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Promo;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Pelanggan;
use App\Models\ProdukPromo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 1 user default
        User::create([
            'id_user' => \Illuminate\Support\Str::uuid(),
            'nama' => 'Admin Laundry',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'aktif',
            'tgl_buat' => now()
        ]);

        User::create([
            'id_user' => \Illuminate\Support\Str::uuid(),
            'nama' => 'Pemilik Laundry',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
            'status' => 'aktif',
            'tgl_buat' => now()
        ]);

        Pelanggan::create([
            'id_pelanggan'   => \Illuminate\Support\Str::uuid(),
            'nama_pelanggan' => 'Jamal Junaidin',
            'username'       => 'jamal',
            'email'          => 'jamal@gmail.com',
            'no_hp'          => '081234567890',
            'password'       => Hash::make('password123'),
            'jk'             => 'L',
            'status'         => 'aktif',
            'tgl_buat'         => now(),
        ]);

        // 🔹 9 kategori
        Kategori::factory(9)->create();

        // 🔹 50 produk realistis
        Produk::factory(50)->create();

        // Promo::factory(10)->create();

         // 4️⃣ ProdukPromo (relasi promo-produk)
        // for ($i = 0; $i < 5; $i++) {
        //     ProdukPromo::factory()->create();
        // }
    }
}
