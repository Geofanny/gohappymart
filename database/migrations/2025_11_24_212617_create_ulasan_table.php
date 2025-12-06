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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->uuid('id_ulasan')->primary();
            
            $table->uuid('id_pesanan');
            $table->uuid('id_produk')->nullable();
            $table->uuid('id_pelanggan');
        
            $table->tinyInteger('rating')->default(0);
            $table->text('ulasan')->nullable();
            $table->text('tipe');
            $table->text('balasan')->nullable();
            $table->timestamp('tgl_ulasan');
                
            // Relasi
            $table->foreign('id_pesanan')
                  ->references('id_pesanan')->on('pesanan')
                  ->onDelete('cascade');
        
            $table->foreign('id_produk')
                  ->references('id_produk')->on('produk')
                  ->onDelete('cascade');
        
            $table->foreign('id_pelanggan')
                  ->references('id_pelanggan')->on('pelanggan')
                  ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
