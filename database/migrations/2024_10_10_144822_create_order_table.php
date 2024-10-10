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
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('code');
            $table->text('cart')->nullable();
            $table->string('address');
            $table->unsignedBigInteger('province_id')->index();
            $table->unsignedBigInteger('district_id')->index();
            $table->unsignedBigInteger('ward_id')->index();
            $table->string('promotions')->nullable()->comment('các mã khuyến mãi');
            $table->text('desc')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->integer('type_user')->default(1)->comment('1 là user có tài khoản , 2 là guest mua');
            $table->unsignedBigInteger('payment_id')->nullable()->index();
            $table->integer('is_pay')->default(0)->comment('0 chưa thanh toán , 1 đã thanh toán');
            $table->integer('approve')->default(1)->comment('1 chờ duyệt, 2 duyệt,');
            $table->integer('shipping')->default(1)->comment('Phương thức vận chuyển');
            $table->integer('status')->default(1)->comment('1 chờ thanh toán, 2 đã thanh tóan,3 là hủy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
