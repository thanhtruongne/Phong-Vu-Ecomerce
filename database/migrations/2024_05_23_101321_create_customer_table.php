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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('customer_cateloge_id');
            $table->foreign('customer_cateloge_id')->references('id')->on('customer_cateloge')->onDelete('cascade');
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('province_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('ward_id')->nullable();
            $table->string('address');
            $table->dateTime('birthday');
            $table->string('phone');
            $table->string('desc');
            $table->text('thumb');
            $table->text('ip');
            $table->string('password');
            $table->bigInteger('status');
            $table->string('user_agent');
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
