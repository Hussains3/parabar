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
        Schema::table('advisory_committees', function (Blueprint $table) {
            $table->longText('message')->after('type')->nullable();
            $table->string('email')->after('message')->nullable();
            $table->string('phone')->after('email')->nullable();
            $table->string('officename')->after('phone')->nullable();
            $table->string('officeaddress')->after('officename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advisory_committees', function (Blueprint $table) {
            $table->dropColumn([
                'message',
                'email',
                'phone',
                'officename',
                'officeaddress'
            ]);
        });
    }
};
