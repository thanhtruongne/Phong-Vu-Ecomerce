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
        Schema::create('post_cateloge_translate', function (Blueprint $table) {
            $table->unsignedBigInteger('post_cateloge_id')->nullable();
            $table->unsignedBigInteger('languages_id')->nullable();
            $table->foreign('post_cateloge_id')->references('id')->on('post_cateloge')->onDelete('cascade');
            $table->foreign('languages_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->longText('content')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->text('meta_desc')->nullable();
            $table->string('meta_link');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_cateloge_translate');
    }
};
