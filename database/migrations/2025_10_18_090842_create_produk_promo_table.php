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
        Schema::create('produk_promo', function (Blueprint $table) {
            $table->uuid('id_produk');
            $table->uuid('id_promo');

            // primary key gabungan (composite)
            $table->primary(['id_produk', 'id_promo']);

            // foreign key
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->foreign('id_promo')->references('id_promo')->on('promo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_promo');
    }
};
