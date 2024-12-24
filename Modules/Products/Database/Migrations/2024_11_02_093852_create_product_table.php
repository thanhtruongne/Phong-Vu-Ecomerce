<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('sku_code')->nullable();
            $table->string('image')->nullable();
            $table->text('album')->nullable();
            $table->integer('views')->nullable();
            $table->text('description')->nullable();
            $table->string('content')->nullable();
            $table->unsignedBigInteger('product_category_id')->index()->nullable();
            $table->unsignedBigInteger('brand_id')->index()->nullable();
            $table->integer('sort')->default(0);
            $table->decimal('price',10)->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('type')->default(1);
            $table->string('attributes')->nullable()->comment('[{attribute_cate -> 1 , attribute : [1,2,3]},...]');
            $table->string('variants')->nullable()->comment('[
                {
                   name : color,
                   image: null,
                   options : [red,blue....]

                }
            ]');
            $table->integer('status')->default(1);
            $table->integer('is_single')->nullable();
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
        Schema::dropIfExists('product');
    }
}
