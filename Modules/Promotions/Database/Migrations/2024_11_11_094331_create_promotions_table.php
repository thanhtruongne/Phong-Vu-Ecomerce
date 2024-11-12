<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',150);
            $table->string('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('code')->unique()->index();
            $table->integer('count')->nullable();
            $table->decimal('amount',10)->nullable();
            $table->dateTime('startDate');
            $table->dateTime('endDate')->nullable();
            $table->integer('neverEndDate');
            $table->integer('status')->default(1);
            $table->integer('type')->nullable()->comment('1 theo danh mục,2 theo sản phẩm');
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
        Schema::dropIfExists('promotions');
    }
}
