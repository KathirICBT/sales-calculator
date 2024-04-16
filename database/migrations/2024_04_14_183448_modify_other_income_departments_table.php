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
        Schema::table('other_income_departments', function (Blueprint $table) {
            // // Drop the 'category' column
            $table->dropColumn('category');

            // // Add the 'category_id' column as foreign key
            // $table->unsignedBigInteger('category_id');
            // $table->foreign('category_id')->references('id')->on('income_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('other_income_departments', function (Blueprint $table) {
            // Re-add the 'category' column
            // $table->string('category');
            
            // // Drop the foreign key constraint
            // $table->dropForeign(['category_id']);
            // $table->dropColumn('category_id');
        });
    }
};
