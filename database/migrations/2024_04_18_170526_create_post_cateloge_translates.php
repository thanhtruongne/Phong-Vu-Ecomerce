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
            $table->unsignedBigInteger('post_cateloge_id')->default(0);
            $table->unsignedBigInteger('languages_id')->default(0);
            $table->foreign('post_cateloge_id')->references('id')->on('post_cateloges')->onDelete('cascade');
            $table->foreign('languages_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('name');
            $table->longText('content');
            $table->text('description');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->text('meta_desc');
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
