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
        Schema::create('post_cateloge_post', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->nullable();
            $table->unsignedBigInteger('post_cateloge_id')->nullable();
            $table->foreign('post_id')->references('id')->on('post')->onDelete('cascade');
            $table->foreign('post_cateloge_id')->references('id')->on('post_cateloge')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_cateloge_post');
    }
};
