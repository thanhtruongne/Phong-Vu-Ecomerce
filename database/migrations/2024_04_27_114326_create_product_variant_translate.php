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
        Schema::create('product_variant_translate', function (Blueprint $table) {
            $table->unsignedBigInteger('product_variant_id')->nullable();
            $table->unsignedBigInteger('languages_id')->nullable();
            $table->foreign('product_variant_id')->references('id')->on('product_variant')->onDelete('cascade');
            $table->foreign('languages_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_translate');
    }
};
