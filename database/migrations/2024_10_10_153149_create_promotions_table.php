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
        // Schema::create('promotions', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('name');
        //     $table->string('code');
        //     $table->dateTime('startDate');
        //     $table->dateTime('endDates');
        //     $table->integer('neverEndDate');
        //     $table->integer('status')->default(1);
        //     $table->string('promotionMethod');
        //     $table->float('maxDiscountValue');
        //     $table->float('discountValue');
        //     $table->integer('discountType')->comment('1 là % , 2 cash');
        //     $table->string('method');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('promotions');
    }
};
