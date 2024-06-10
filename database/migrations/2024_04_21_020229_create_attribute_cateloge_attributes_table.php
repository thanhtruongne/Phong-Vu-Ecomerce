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
        Schema::create('attribute_cateloge_attribute', function (Blueprint $table) {
    $table->unsignedBigInteger('attribute_cateloge_id');
    $table->unsignedBigInteger('attribute_id');
    $table->foreign('attribute_cateloge_id')->references('id')->on('attribute_cateloge')->onDelete('cascade');
    $table->foreign('attribute_id')->references('id')->on('attribute')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_cateloge_attribute');
    }
};