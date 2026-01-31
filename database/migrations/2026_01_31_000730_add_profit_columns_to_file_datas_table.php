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
        Schema::table('file_datas', function (Blueprint $table) {
            $table->decimal('miscellaneous_cost_total', 10, 2)->default(0)->after('miscellaneous_total');
            $table->decimal('approximate_profit', 10, 2)->default(0)->after('total_paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_datas', function (Blueprint $table) {
            $table->dropColumn(['miscellaneous_cost_total', 'approximate_profit']);
        });
    }
};
