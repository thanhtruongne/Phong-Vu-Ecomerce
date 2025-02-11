<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index();
            $table->bigInteger('order_id')->index();
            $table->string('subject')->comment('Tiêu đề thông báo');
            $table->text('content')->nullable()->comment('Nội dung thông báo');
            $table->text('url')->nullable()->comment('Liên kết đến của thông báo');
            $table->bigInteger('created_by')->comment('Người gửi / 0: hệ thống');
            $table->tinyInteger('viewed')->index()->default(0)->comment('Đã xem');
            $table->tinyInteger('status')->default(2)->comment('2 - null: Chưa gửi, 3: đang gửi, 1: đã gửi, 0: lỗi');
            $table->text('error')->nullable();
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
        Schema::dropIfExists('notify');
    }
}
