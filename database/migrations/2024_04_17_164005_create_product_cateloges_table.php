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
        Schema::create('product_cateloge_translate', function (Blueprint $table) {
    $table->unsignedBigInteger('product_cateloge_id')->nullable();
    $table->unsignedBigInteger('languages_id')->nullable();
    $table->foreign('product_cateloge_id')->references('id')->on('product_cateloge')->onDelete('cascade');
    $table->foreign('languages_id')->references('id')->on('languages')->onDelete('cascade');
    $table->string('name');
    $table->longText('content');
    $table->text('desc');
    $table->string('meta_title');
    $table->string('meta_keyword');
    $table->text('meta_desc');
    $table->string('meta_link');
    $table->timestamps();
});    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_cateloge_translate');
    }
};