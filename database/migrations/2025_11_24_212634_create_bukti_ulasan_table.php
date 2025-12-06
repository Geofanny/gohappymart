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
        Schema::create('bukti_ulasan', function (Blueprint $table) {
            $table->uuid('id_foto')->primary();

            $table->uuid('id_ulasan');      
            $table->string('nama_file');         
            
            // Relasi ke ulasan
            $table->foreign('id_ulasan')
                ->references('id_ulasan')->on('ulasan')
                ->onDelete('cascade');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_ulasan');
    }
};
