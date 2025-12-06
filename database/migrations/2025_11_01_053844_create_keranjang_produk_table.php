<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keranjang_produk', function (Blueprint $table) {
            $table->uuid('id_keranjang_produk')->primary(); // pakai UUID
            $table->uuid('id_keranjang'); // relasi ke keranjang
            $table->uuid('id_produk'); // relasi ke produk
            $table->integer('jumlah')->default(1);
            $table->timestamp('tgl_ditambahkan')->useCurrent();

            // foreign key
            $table->foreign('id_keranjang')->references('id_keranjang')->on('keranjang')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_produk');
    }
};
