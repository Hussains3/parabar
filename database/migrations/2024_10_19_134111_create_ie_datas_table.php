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
        Schema::create('ie_datas', function (Blueprint $table) {
            $table->id();
            $table->string('org_name')->nullable();
            $table->string('org_logo')->nullable();
            $table->string('bin_no')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('name')->nullable();
            $table->string('fax_telephone')->nullable();
            $table->string('phone_primary')->nullable();
            $table->string('phone_secondary')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email_primary')->nullable();
            $table->string('email_secondary')->nullable();
            $table->string('house_distric')->nullable();
            $table->string('address')->nullable();
            $table->string('post')->nullable();
            $table->string('commission_percentage')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ie_datas');
    }
};
