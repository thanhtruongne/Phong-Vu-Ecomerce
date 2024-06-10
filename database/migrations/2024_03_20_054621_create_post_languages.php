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
        Schema::create('post_languages', function (Blueprint $table) {
            $table->unsignedBigInteger('posts_id');
            $table->unsignedBigInteger('languages_id');
            $table->foreign('languages_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreign('posts_id')->references('id')->on('posts')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->longText('content');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->string('meta_content');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_languages');
    }
};
