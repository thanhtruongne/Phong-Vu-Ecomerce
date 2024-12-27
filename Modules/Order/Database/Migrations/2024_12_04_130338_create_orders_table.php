<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique()->index();
            $table->unsignedBigInteger('user_id');
            $table->dateTime('create_time')->nullable()->comment('Thời gian tạo đơn hàng');
            $table->string('user_name')->nullable();
            $table->decimal('total_amount',10,2);
            $table->decimal('freight_amount',10,2)->comment('Tiền vận chuyển');
            $table->decimal('promotion_amount',10,2)->comment('Số tiền khuyến mãi ');
            $table->integer('pay_type')->nullable()->comment('Phương thức thanh toán: 0->Chưa thanh toán; 1->Cash; 2->Thẻ');
            $table->integer('status')->nullable()->comment('Trạng thái đơn hàng: 0->đang chờ thanh toán; 1->đang chờ giao hàng; 2->đã giao hàng; 3->đã hoàn thành; 4->đã đóng');
            $table->string('delivery_company')->default('GHTK');
            $table->string('delivery_code')->nullable();
            // $table->string('receiver_name')->nullable();
            // $table->string('receiver_phone')->nullable();
            // $table->string('receiver_email')->nullable();
            // $table->string('receiver_post_code')->nullable();
            // $table->string('receiver_province')->nullable();
            // $table->string('receiver_district')->nullable();
            // $table->string('receiver_ward')->nullable();
            // $table->string('receiver_address')->nullable();
            $table->unsignedBigInteger('address_id');
            $table->integer('confirm_status')->nullable()->comment('Xác nhận trạng thái nhận: 0->Chưa xác nhận; 1->Đã xác nhận;');
            $table->integer('delete_status')->nullable()->comment('Trạng thái xóa: 0->chưa xóa; 1->đã xóa;');
            $table->text('note')->nullable();
            $table->dateTime('payment_time')->nullable();
            $table->dateTime('delivery_time')->nullable();
            $table->integer('mail_completed')->nullable()->comment('số lần gủi mail khi thanh toán thành công');
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
        Schema::dropIfExists('orders');
    }
}
