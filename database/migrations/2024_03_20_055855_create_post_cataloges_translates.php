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
        Schema::create('post_cataloges_translates', function (Blueprint $table) {
            $table->unsignedBigInteger('post_cataloges_id');
            $table->unsignedBigInteger('languages_id');
            $table->foreign('post_cataloges_id')->references('id')->on('post_cataloges')->onDelete('cascade');
            $table->foreign('languages_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->longText('content');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->string('meta_desc');
            $table->string('meta_seo_link')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_cataloges_translates');
    }
};
