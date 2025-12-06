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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->uuid('id_pengembalian')->primary();
            $table->uuid('id_pesanan'); // foreign key ke tabel pesanan
            $table->string('no_pengembalian');
            $table->text('alasan');
            $table->text('deskripsi');
            $table->text('solusi');
            $table->string('status');
            $table->string('no_resi_pengembalian')->nullable();
            $table->string('no_resi_balasan')->nullable();
            $table->dateTime('tgl_pengajuan');
            $table->dateTime('tgl_selesai')->nullable();

            // foreign key ke tabel pesanan
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
