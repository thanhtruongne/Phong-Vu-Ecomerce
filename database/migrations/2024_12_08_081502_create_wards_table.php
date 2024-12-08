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
        Schema::create('wards', function (Blueprint $table) {
            $table->string('code', 10)->unique()->index(); // Mã phường/xã
            $table->string('name', 100); // Tên phường/xã (tiếng Việt)
            $table->string('name_en', 100)->nullable(); // Tên phường/xã (tiếng Anh)
            $table->string('full_name', 200); // Tên đầy đủ (tiếng Việt)
            $table->string('full_name_en', 200)->nullable(); // Tên đầy đủ (tiếng Anh)
            $table->string('code_name', 100)->unique(); // Tên mã hóa
            $table->string('district_code', 10); // Mã quận/huyện liên kết
            $table->unsignedBigInteger('administrative_unit_id'); // ID đơn vị hành chính
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};
