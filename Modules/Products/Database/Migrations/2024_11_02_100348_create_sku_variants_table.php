<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkuVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('sku_idx')->nullable()->comment('[0,1]'); // lấy theo phần index của product
            $table->unsignedBigInteger('product_id')->index()->nullable();
            $table->string('sku_code')->unique();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->decimal('price',10)->nullable();
            $table->integer('sort')->default(0);
            $table->integer('stock')->default(0);
            $table->integer('default')->default(0);
            $table->text('album')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sku_variants');
    }
}
