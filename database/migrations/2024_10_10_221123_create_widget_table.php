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
        Schema::create('widget', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',150);
            $table->string('keyword')->nullable();
            $table->text('content')->nullable();
            $table->text('model_id');
            $table->string('short_code')->nullable();
            $table->string('image');
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widget');
    }
};
