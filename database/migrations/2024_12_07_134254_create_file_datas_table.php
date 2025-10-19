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
        Schema::create('file_datas', function (Blueprint $table) {
            $table->id();
            $table->string('lodgement_no')->nullable();
            $table->date('lodgement_date')->nullable();
            $table->string('manifest_no')->nullable();
            $table->date('manifest_date')->nullable();
            $table->string('group')->nullable();
            $table->string('ie_type')->nullable();
            $table->string('ie_group')->nullable();
            $table->string('goods_name')->nullable();
            $table->string('goods_type')->nullable();
            $table->string('be_number')->nullable()->unique();
            $table->date('be_date')->nullable();
            $table->string('fees')->nullable();
            $table->string('page')->nullable();
            $table->string('no_of_items')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('ie_data_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('reciver_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('operator_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('deliverer_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->boolean('sms_sent')->default(false);
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_datas');
    }
};
