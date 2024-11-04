<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesVariantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories_variant', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_cateloge_id')->index()->nullable();
            // $table->unsignedBigInteger('product_id')->index()->nullable();
            $table->unsignedBigInteger('sku_id')->index()->nullable();
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
        Schema::dropIfExists('product_categories_variant');
    }
}
