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
        Schema::table('other_incomes', function (Blueprint $table) {
            // Add 'date' column
            $table->date('date')->nullable();

            // Add 'shop_id' column
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->foreign('shop_id')->references('id')->on('shops');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('other_incomes', function (Blueprint $table) {
            // Drop 'date' column
            $table->dropColumn('date');

            // Drop 'shop_id' column
            $table->dropForeign(['shop_id']);
            $table->dropColumn('shop_id');
        });
    }
};
