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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->unsignedBigInteger('category_id');
            $table->integer('price');
            $table->integer('stock');
            $table->string('brand', 100);
            $table->integer('berat')->nullable();
            $table->string('satuan', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
