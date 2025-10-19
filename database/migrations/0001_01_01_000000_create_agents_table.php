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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bangla_name')->nullable();
            $table->date('license_issue_date')->nullable();
            $table->string('license_no')->nullable();
            $table->string('license_status')->nullable();
            $table->string('ain_no')->unique()->nullable();
            $table->string('membership_no')->nullable();
            $table->string('owners_name')->nullable();
            $table->string('owners_gender')->nullable();
            $table->string('owners_designation')->nullable();
            $table->string('owner_photo')->nullable();
            $table->string('agency_logo')->nullable();
            $table->string('office_address')->nullable();
            $table->string('parmanent_address')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('house');
            $table->longText('note')->nullable();
            $table->json('others_owner')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
