<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_cateloge_product', function (Blueprint $table) {
    $table->unsignedBigInteger('product_cateloge_id');
    $table->unsignedBigInteger('product_id');
    $table->foreign('product_cateloge_id')->references('id')->on('product_cateloge')->onDelete('cascade');
    $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_cateloge_product');
    }
};