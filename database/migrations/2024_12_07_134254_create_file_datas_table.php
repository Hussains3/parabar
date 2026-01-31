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
            $table->string('be_number')->nullable()->unique();
            $table->string('manifest_number')->nullable();
            $table->string('job_no')->nullable();
            $table->string('bill_no')->nullable();
            $table->foreignId('ie_data_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('file_date')->nullable();
            $table->string('package')->nullable();
            $table->date('delivary_date')->nullable();
            $table->string('lc_no')->nullable();
            $table->string('net_wt')->nullable();
            $table->string('goods_name')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('be_date')->nullable();
            $table->string('lc_value')->nullable();
            $table->string('dollar_rate')->nullable();
            $table->string('ass_value')->nullable();
            $table->date('goods_recept_date')->nullable();
            $table->date('document_recept_date')->nullable();
            $table->date('bond_license_recept_date')->nullable();
            $table->date('advance_paid_date')->nullable();


            $table->json('remarks')->nullable()->comment('Array of remarks with name and value');
            $table->json('receptables')->nullable()->comment('Array of receptable with description, number, date and amount');
            $table->string('receptable_total')->nullable();
            $table->json('miscellaneouses')->nullable()->comment('Array of miscellaneous with description, number, date and amount');
            $table->string('miscellaneous_total')->nullable();


            $table->string('total')->nullable();
            $table->string('advance')->nullable();
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('total_in_word')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();


            $table->string('lc_bank')->nullable();


            $table->json('payments')->nullable()->comment('Array of payment records with amount and date');
            $table->decimal('total_paid', 10, 2)->default(0);


            $table->string('status')->default('Unpaid');
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
