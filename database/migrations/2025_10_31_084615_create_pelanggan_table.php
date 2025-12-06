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
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->uuid('id_pelanggan')->primary(); // UUID sebagai primary key
            $table->string('nama_pelanggan',50);
            $table->string('username',50);
            $table->string('email');
            $table->string('no_hp')->nullable();
            $table->string('password');
            $table->datetime('tgl_buat');
            $table->char('jk',1);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
