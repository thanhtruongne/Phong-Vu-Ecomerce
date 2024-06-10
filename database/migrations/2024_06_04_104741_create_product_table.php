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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->integer('product_cateloge_id')->default(0);
            $table->text('image');
            $table->string('icon');
            $table->text('album')->nullable();
            $table->boolean('status')->default(0);
            $table->integer('order')->default(0);
            $table->integer('follow')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('price')->nullable();
            $table->string('code_product')->nullable();
            $table->string('form')->nullable();
            $table->text('attribute')->nullable();
            $table->text('attributeCateloge')->nullable();
            $table->text('variant')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};