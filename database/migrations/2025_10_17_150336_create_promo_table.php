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
        Schema::create('promo', function (Blueprint $table) {
            $table->uuid('id_promo')->primary();
            // Relasi ke user
            $table->uuid('id_user');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->string('nama_promo');
            $table->enum('tipe', ['Persen', 'Nominal']);
            $table->integer('nilai_diskon'); 
            $table->string('banner'); 
            $table->string('kategori',30); 
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_selesai');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo');
    }
};
