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
        Schema::create('item_pengembalian', function (Blueprint $table) {
            $table->uuid('id_item')->primary();
            $table->uuid('id_pengembalian'); // foreign key ke pengembalian
            $table->uuid('id_produk'); // foreign key ke tabel produk

            // foreign key constraints
            $table->foreign('id_pengembalian')->references('id_pengembalian')->on('pengembalian')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pengembalian');
    }
};
