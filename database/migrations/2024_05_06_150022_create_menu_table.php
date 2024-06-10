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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_cateloge_id')->nullable();
            $table->text('image')->nullable();
            $table->text('album')->nullable();
            $table->boolean('status')->default(0);
            $table->integer('order')->default(0);
            $table->string('type')->nullable();
            $table->bigInteger('position')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('menu_cateloge_id')->references('id')->on('menu_cateloge')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
