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
        Schema::table('petticashes', function (Blueprint $table) {
            Schema::table('petticashes', function (Blueprint $table) {
                $table->unsignedBigInteger('petty_cash_reason_id')->nullable();
                $table->foreign('petty_cash_reason_id')->references('id')->on('petty_cash_reasons');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('petticashes', function (Blueprint $table) {
            $table->dropForeign(['petty_cash_reason_id']);
            $table->dropColumn('petty_cash_reason_id');
        });
    }
};
