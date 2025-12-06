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
        Schema::create('regulasi', function (Blueprint $table) {
            $table->uuid('id_regulasi')->primary(); // pakai UUID
            $table->uuid('id_user'); // relasi ke user (juga UUID)
            $table->string('jenis', 100);
            $table->string('judul', 150)->nullable();
            $table->text('isi');
            $table->timestamp('tgl_publikasi')->useCurrent();

            // opsional: tambahkan foreign key jika tabel user pakai uuid juga
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regulasi');
    }
};
