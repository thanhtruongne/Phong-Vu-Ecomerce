<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payment', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->index();
            $table->integer('method_payment')->default(1)->comment('Thanh toán trực tiếp');
            $table->string('label_id')->nullable();
            $table->string('unit_transport')->nullable();
            $table->integer('unit_payment')->nullable()->comment('1 momo , 2 vn pay , 3 ,paypal , 4 zalopay');
            $table->string('partner_id')->nullable()->comment('mã đối tác');
            $table->text('detail_payment')->nullable();
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
        Schema::dropIfExists('order_payment');
    }
}
