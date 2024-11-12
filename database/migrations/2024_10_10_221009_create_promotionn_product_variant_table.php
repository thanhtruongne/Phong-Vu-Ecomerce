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
        // Schema::create('promotionn_product_variant', function (Blueprint $table) {
        //     $table->unsignedBigInteger('product_id')->index()->comment('trg hợp để variant null thì toàn bộ sp giảm theo');
        //     $table->unsignedBigInteger('product_variant_id')->index();
        //     $table->unsignedBigInteger('promotions_id')->index();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('promotionn_product_variant');
    }
};
