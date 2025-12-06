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
        Schema::create('produk', function (Blueprint $table) {
            $table->uuid('id_produk')->primary(); // pakai UUID untuk konsisten dengan kategori
            $table->uuid('id_kategori'); // relasi ke tabel kategori (UUID juga)
            $table->string('sku', 50)->unique(); // kode unik produk
            $table->string('nama_produk', 100);
            $table->text('deskripsi')->nullable();
            $table->integer('harga'); // format harga dengan dua angka desimal
            $table->integer('stok');
            $table->string('gambar')->nullable(); // bisa null kalau belum ada gambar
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamp('tgl_ditambahkan')->useCurrent();

            // Relasi ke kategori
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
