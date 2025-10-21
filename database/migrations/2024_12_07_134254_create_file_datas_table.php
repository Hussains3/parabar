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
            $table->string('package')->nullable();
            $table->date('file_date')->nullable();
            $table->string('lc_no')->nullable();
            $table->string('lc_value')->nullable();
            $table->string('lc_bank')->nullable();
            $table->string('bill_no')->nullable();

            // Coat Fee
            $table->integer('actual_coat_fee')->default(25);
            $table->integer('bill_coat_fee')->default(0);

            // Association B/E Entry Fee
            $table->integer('actual_asso_be_entry_fee')->default(0);
            $table->integer('bill_asso_be_entry_fee')->default(0);
            // Cargo Branch
            $table->integer('actual_cargo_branch_aro')->default(0);
            $table->integer('bill_cargo_branch_aro')->default(0);
            $table->integer('actual_cargo_branch_ro')->default(0);
            $table->integer('bill_cargo_branch_ro')->default(0);
            $table->integer('actual_cargo_branch_ac')->default(0);
            $table->integer('bill_cargo_branch_ac')->default(0);
            // Manifest Dept.
            $table->integer('actual_manifest_dept')->default(0);
            $table->integer('bill_manifest_dept')->default(0);
            // 42 Number Shed
            $table->integer('actual_fourtytwo_shed_aro')->default(0);
            $table->integer('bill_fourtytwo_shed_aro')->default(0);
            // Examination
            $table->integer('actual_examination_normal')->default(0);
            $table->integer('actual_examination_irm')->default(0);
            $table->integer('actual_examination_goinda')->default(0);
            $table->integer('bill_examination_normal')->default(0);
            $table->integer('bill_examination_irm')->default(0);
            $table->integer('bill_examination_goinda')->default(0);
            // Assessement
            $table->integer('actual_assessement_aro')->default(0);
            $table->integer('actual_assessement_ro')->default(0);
            $table->integer('actual_assessement_ac')->default(0);
            $table->integer('actual_assessement_dc')->default(0);
            $table->integer('actual_assessement_jc')->default(0);
            $table->integer('actual_assessement_adc')->default(0);
            $table->integer('actual_assessement_commissionar')->default(0);

            $table->integer('bill_assessement_aro')->default(0);
            $table->integer('bill_assessement_ro')->default(0);
            $table->integer('bill_assessement_ac')->default(0);
            $table->integer('bill_assessement_dc')->default(0);
            $table->integer('bill_assessement_jc')->default(0);
            $table->integer('bill_assessement_adc')->default(0);
            $table->integer('bill_assessement_commissionar')->default(0);
            // Lab Test Fee
            $table->integer('actual_lab_test_fee_receptable')->default(0);
            $table->integer('actual_lab_test_fee_sample_processing')->default(0);
            $table->integer('bill_lab_test_fee_receptable')->default(0);
            $table->integer('bill_lab_test_fee_sample_processing')->default(0);
            // Group+Sipay
            $table->integer('actual_group_sipay')->default(0);
            $table->integer('bill_group_sipay')->default(0);
            // Bank Chalan
            $table->integer('actual_bank_chalan')->default(0);
            $table->integer('bill_bank_chalan')->default(0);
            // Bank Chalan (Evening charge)
            $table->integer('actual_bank_chalan_evening')->default(0);
            $table->integer('bill_bank_chalan_evening')->default(0);
            // Delivery cost
            $table->integer('actual_delivery_cost')->default(0);
            $table->integer('bill_delivery_cost')->default(0);
            // Unstamping Department
            $table->integer('actual_unstamping_dep_ro')->default(0);
            $table->integer('bill_unstamping_dep_ro')->default(0);
            $table->integer('actual_unstamping_dep_aro')->default(0);
            $table->integer('bill_unstamping_dep_aro')->default(0);

            // Loading/Un-Loading
            $table->integer('actual_load_unload')->default(0);
            $table->integer('bill_load_unload')->default(0);
            // Shed
            $table->integer('actual_shed')->default(0);
            $table->integer('bill_shed')->default(0);
            // Exit
            $table->integer('actual_exit')->default(0);
            $table->integer('bill_exit')->default(0);
            // Finaly Out get
            $table->integer('actual_finaly_out_get')->default(0);
            $table->integer('bill_finaly_out_get')->default(0);
            // File Commission
            $table->integer('actual_file_commission')->default(0);
            $table->integer('bill_file_commission')->default(0);
            // Other Cost
            $table->integer('actual_other_cost')->default(0);
            $table->integer('bill_other_cost')->default(0);
            //Total
            $table->integer('actual_total')->default(0);
            $table->integer('bill_total')->default(0);

            $table->foreignId('ie_data_id')->nullable()->constrained()->onDelete('cascade');
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
