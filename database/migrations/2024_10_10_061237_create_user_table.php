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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->text('avatar')->nullable();
            $table->string('firstname',150);
            $table->string('lastname',150); 
            $table->dateTime('last_login')->nullable();
            $table->string('email')->unique();
            $table->boolean('re_login')->default(0);
            $table->boolean('type_user')->default(1)->comment('1 user đăng ký , 2 guest mua hàng sau đó tự tạo tài khoản bằng mail');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->dateTime('dob')->nullable();
            $table->string('role',150)->default('user');
            $table->string( 'address')->nullable();
            $table->string('province_code')->index()->nullable();
            $table->string('district_code')->index()->nullable();
            $table->string('ward_code')->index()->nullable();
            $table->integer('gender')->default(1)->comment('1:Nam, 0:Nữ');
            $table->string('phone', 50)->nullable();
            $table->dateTime('signing_create_account')->nullable()->comment('Ngày tạo tài khoản');
            $table->integer('status')->default(1)->comment('0: Block, 1: Active');
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
