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
        Schema::table('petty_cash_reasons', function (Blueprint $table) {
            $table->enum('supplier', ['Supplier', 'Other'])->default('Other');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('petty_cash_reasons', function (Blueprint $table) {
            $table->dropColumn('supplier');
        });
    }
};