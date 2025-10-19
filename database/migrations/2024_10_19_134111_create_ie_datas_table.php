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
            $table->string('bin_no')->nullable();
            $table->string('ie')->nullable();
            $table->string('name')->unique();
            $table->string('owners_name')->nullable();
            $table->string('photo')->nullable();
            $table->string('destination')->nullable();
            $table->string('office_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('house')->nullable();
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
