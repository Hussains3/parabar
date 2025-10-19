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
        Schema::create('i_t_c_reports', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the report
            $table->string('type'); // Type of the report
            $table->string('file_link'); // Link to the uploaded PDF file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_t_c_reports');
    }
};
