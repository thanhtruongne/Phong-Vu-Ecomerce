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
        Schema::create('product_variant', function (Blueprint $table) {
            $table->string('code',150);
            $table->string('sku',150)->unique();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('name')->nullable();
            $table->longText('album')->nullable();
            $table->bigInteger('views')->default(0);
            $table->string('image')->nullable();
            $table->bigInteger('qualnity')->default(0);
            $table->float('price');
            $table->longText('attribute')->nullable()->comment('cateloge => {item,item,item}');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant');
    }
};
