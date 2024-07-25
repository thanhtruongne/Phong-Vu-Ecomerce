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
        Schema::create('promotion_product_variant', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('promotion_id');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->foreign('promotion_id')->references('id')->on('promotion')->onDelete('cascade');
            $table->unsignedBigInteger('product_variant_id')->nullable();
            $table->string('model');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_product_variant');
    }
};
