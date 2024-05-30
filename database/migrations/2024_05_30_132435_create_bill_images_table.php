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
        Schema::create('bill_images', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->string('image');
            $table->timestamps();

            // Define foreign keys
            $table->foreign('staff_id')->references('id')->on('staffs');
            $table->foreign('shop_id')->references('id')->on('shops');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_images');
    }
};
