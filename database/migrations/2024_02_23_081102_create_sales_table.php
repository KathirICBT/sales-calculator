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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dept_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('shop_id');
            $table->decimal('amount', 10, 2); 

            // Define foreign key constraints
            $table->foreign('dept_id')->references('id')->on('departments');
            $table->foreign('staff_id')->references('id')->on('staffs');
            $table->foreign('shop_id')->references('id')->on('shops');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
