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
        // Tabel pesanan
        Schema::create('pesanan', function (Blueprint $table) {
            $table->uuid('id_pesanan')->primary();
            $table->uuid('id_pelanggan');
            $table->dateTime('tgl_pesanan');
            $table->string('status');
            $table->string('no_pesanan');
            $table->bigInteger('total_harga')->default(0);
            $table->text('catatan')->nullable();
            $table->text('alasan')->nullable();

            // foreign key ke tabel pelanggan
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
