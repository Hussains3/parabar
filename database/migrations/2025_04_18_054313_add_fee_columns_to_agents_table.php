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
        Schema::table('agents', function (Blueprint $table) {
            $table->decimal('member_fee_amount', 10, 2)->default(40)->after('note');
            $table->decimal('welfare_fund_amount', 10, 2)->default(40)->after('member_fee_amount');
            $table->date('last_fee_paid_date')->nullable()->after('welfare_fund_amount');
            $table->date('member_fee_paid_till_date')->nullable()->after('last_fee_paid_date');
            $table->date('welfare_fund_paid_till_date')->nullable()->after('member_fee_paid_till_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn([
                'member_fee_amount',
                'welfare_fund_amount',
                'last_fee_paid_date',
                'member_fee_paid_till_date',
                'welfare_fund_paid_till_date'
            ]);
        });
    }
};
