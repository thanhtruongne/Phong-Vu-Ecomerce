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
            $table->id();
            $table->string('name');
            $table->string('keyword');
            $table->longText('model');
            $table->longText('mode_id');
            $table->longText('album');
            $table->string('desc')->nullable();
            $table->string('short_code');
            $table->softDeletes();
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
