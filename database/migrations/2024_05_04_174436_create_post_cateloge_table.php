<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_cateloge', function (Blueprint $table) {
            $table->id();
            NestedSet::columns($table);
            $table->text('image');
            $table->string('icon')->nullable();
            $table->text('album')->nullable();
            $table->boolean('status')->default(0);
            $table->integer('order')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->boolean('follow')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_cateloge');
    }
};
