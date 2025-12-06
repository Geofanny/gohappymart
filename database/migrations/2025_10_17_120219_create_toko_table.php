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
        Schema::create('toko', function (Blueprint $table) {
            $table->uuid('id_toko')->primary(); // UUID untuk id toko
            $table->string('logo')->nullable();
            $table->string('gambar')->nullable();
            $table->string('nama');
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('tagline')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('alamat')->nullable();
            $table->uuid('id_user'); // UUID sebagai foreign key ke users

            // Tambahkan foreign key constraint
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toko');
    }
};
