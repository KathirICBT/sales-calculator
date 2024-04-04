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
        Schema::create('other_incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('other_income_department_id');
            $table->foreign('other_income_department_id')->references('id')->on('other_income_departments');
            $table->unsignedBigInteger('paymenttype_id');
            $table->foreign('paymenttype_id')->references('id')->on('payment_types');
            $table->decimal('amount', 10, 2); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_incomes');
    }
};
