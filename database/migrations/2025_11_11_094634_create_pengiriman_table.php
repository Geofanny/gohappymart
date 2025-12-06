<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->uuid('id_pengiriman')->primary();
            $table->uuid('id_pesanan')->unique(); // 1:1
            $table->string('status', 50); // bisa dikirim, diterima
            $table->dateTime('tgl_kirim')->nullable();
            $table->dateTime('tgl_selesai')->nullable();
            $table->text('alamat');
            $table->string('jasa_kirim');
            $table->string('ongkir');
            $table->string('no_resi')->nullable();

            // foreign key ke pesanan
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
