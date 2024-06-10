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
        Schema::create('attribute_translate', function (Blueprint $table) {
    $table->unsignedBigInteger('attribute_id')->nullable();
    $table->unsignedBigInteger('languages_id')->nullable();
    $table->foreign('attribute_id')->references('id')->on('attribute')->onDelete('cascade');
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
        Schema::dropIfExists('attribute_translate');
    }
};