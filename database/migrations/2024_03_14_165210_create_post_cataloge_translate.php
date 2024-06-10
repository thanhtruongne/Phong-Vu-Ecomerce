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
        Schema::create('post_cataloge_translate', function (Blueprint $table) {
            $table->unsignedBigInteger('post_cataloge_id');
            $table->unsignedBigInteger('languages_id');
            $table->foreign('post_cataloge_id')->references('id')->on('post_cataloge')->onDelete('cascade');
            $table->foreign('languages_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->longText('content');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->string('meta_desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_cataloge_translate');
    }
};
