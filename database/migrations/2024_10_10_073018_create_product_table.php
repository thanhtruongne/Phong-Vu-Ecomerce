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
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',150);
            $table->string('name')->nullable();
            $table->longText('content')->nullable();
            $table->bigInteger('qualnity')->default(0);
            $table->bigInteger('views')->default(0);
            $table->longText('desc')->nullable();
            $table->longText('attribute')->nullable();
            $table->unsignedBigInteger('product_cateloge_id')->index();
            $table->tinyInteger('status')->default(1);
            $table->bigInteger('price');
            $table->tinyInteger('type')->nullable();
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
