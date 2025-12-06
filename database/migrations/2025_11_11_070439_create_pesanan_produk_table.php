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
        Schema::create('pesanan_produk', function (Blueprint $table) {
            $table->uuid('id_pesananProduk')->primary();
            $table->uuid('id_pesanan');
            $table->uuid('id_produk');
            $table->integer('jumlah')->default(1);

            // foreign key ke tabel pesanan
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            // foreign key ke tabel produk
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_produk');
    }
};
