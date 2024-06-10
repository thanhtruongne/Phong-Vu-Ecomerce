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
        Schema::create('product_cateloge', function (Blueprint $table) {
            $table->id();
            $table->integer('level')->nullable()->default(0);
            $table->text('image');
            $table->string('icon')->nullable();
            $table->text('album')->nullable();
            $table->boolean('status')->default(0);
            $table->integer('order')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->boolean('follow')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id')->references('id')->on('categories')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_cateloge');
    }
};