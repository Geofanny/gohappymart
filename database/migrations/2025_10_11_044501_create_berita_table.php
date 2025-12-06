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
        Schema::create('berita', function (Blueprint $table) {
            $table->uuid('id_berita')->primary(); // UUID untuk primary key
            $table->uuid('id_user'); // UUID untuk relasi ke users
            $table->string('judul'); // judul berita
            $table->text('isi'); // isi berita
            $table->enum('status', ['draft', 'publish'])->default('draft'); // status
            $table->string('gambar')->nullable();
            $table->integer('pengunjung')->nullable();
            $table->timestamp('tgl')->useCurrent();

            // Relasi ke users
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
