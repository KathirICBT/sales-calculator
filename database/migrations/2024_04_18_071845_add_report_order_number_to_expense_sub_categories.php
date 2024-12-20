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
        Schema::table('expense_sub_categories', function (Blueprint $table) {
            $table->integer('report_order_number')->after('category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_sub_categories', function (Blueprint $table) {
            $table->dropColumn('report_order_number');
        });
    }
};
