<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\File_data;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class FileDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get IE data IDs for foreign key relationship
        $ieDataIds = DB::table('ie_datas')->pluck('id')->toArray();
        if (empty($ieDataIds)) {
            throw new \Exception('No IE data records found. Please seed IE data first.');
        }

        // Generate dates from 2022 to today
        $startDate = Carbon::createFromDate(2022, 1, 1);
        $endDate = Carbon::today();

        // Generate 1000 records
        for ($i = 0; $i < 100; $i++) {
            // Generate a random date between start and end date
            $randomDate = Carbon::createFromTimestamp(
                rand($startDate->timestamp, $endDate->timestamp)
            );

            // Format date as d/m/Y for the mutator
            $fileDate = $randomDate->format('d/m/Y');

            // Calculate realistic fees
            $actualCoatFee = $faker->numberBetween(5000, 15000);
            $billCoatFee = $actualCoatFee + $faker->numberBetween(1000, 3000);

            // Generate payment data
            $totalPaid = $faker->numberBetween(0, $billCoatFee);
            $balance = $billCoatFee - $totalPaid;

            // Create payments array if there's any payment
            $payments = [];
            if ($totalPaid > 0) {
                $remainingAmount = $totalPaid;
                $numPayments = $faker->numberBetween(1, 3);

                for ($j = 0; $j < $numPayments; $j++) {
                    if ($j == $numPayments - 1) {
                        $amount = $remainingAmount;
                    } else {
                        $amount = $faker->numberBetween(1000, $remainingAmount - 1000);
                        $remainingAmount -= $amount;
                    }

                    $payments[] = [
                        'amount' => $amount,
                        'date' => $randomDate->addDays($faker->numberBetween(1, 30))->format('Y-m-d'),
                        'note' => $faker->randomElement(['Cash payment', 'Bank transfer', 'Check payment'])
                    ];
                }
            }

            File_data::create([
                'be_number' => 'BE' . $faker->unique()->numberBetween(10000, 99999),
                'manifest_number' => 'MN' . $faker->numberBetween(1000, 9999),
                'package' => $faker->numberBetween(1, 100),
                'file_date' => $fileDate,
                'lc_no' => 'LC' . $faker->numberBetween(100000, 999999),
                'lc_value' => $faker->numberBetween(100000, 1000000),
                'lc_bank' => $faker->randomElement(['Sonali Bank', 'Janata Bank', 'Agrani Bank', 'Rupali Bank', 'DBBL', 'BRAC Bank']),
                'bill_no' => 'BILL' . $faker->numberBetween(1000, 9999),
                'actual_coat_fee' => $actualCoatFee,
                'bill_coat_fee' => $billCoatFee,
                'actual_asso_be_entry_fee' => $faker->numberBetween(500, 1500),
                'bill_asso_be_entry_fee' => $faker->numberBetween(1500, 2500),
                'actual_cargo_branch_aro' => $faker->numberBetween(200, 800),
                'bill_cargo_branch_aro' => $faker->numberBetween(800, 1500),
                'actual_cargo_branch_ro' => $faker->numberBetween(200, 800),
                'bill_cargo_branch_ro' => $faker->numberBetween(800, 1500),
                'actual_cargo_branch_ac' => $faker->numberBetween(200, 800),
                'bill_cargo_branch_ac' => $faker->numberBetween(800, 1500),
                'actual_manifest_dept' => $faker->numberBetween(300, 1000),
                'bill_manifest_dept' => $faker->numberBetween(1000, 2000),
                'actual_fourtytwo_shed_aro' => $faker->numberBetween(300, 1000),
                'bill_fourtytwo_shed_aro' => $faker->numberBetween(1000, 2000),
                'actual_examination_normal' => $faker->numberBetween(500, 1500),
                'actual_examination_irm' => $faker->numberBetween(500, 1500),
                'actual_examination_goinda' => $faker->numberBetween(500, 1500),
                'bill_examination_normal' => $faker->numberBetween(1500, 2500),
                'bill_examination_irm' => $faker->numberBetween(1500, 2500),
                'bill_examination_goinda' => $faker->numberBetween(1500, 2500),
                'actual_assessement_aro' => $faker->numberBetween(200, 800),
                'actual_assessement_ro' => $faker->numberBetween(200, 800),
                'actual_assessement_ac' => $faker->numberBetween(200, 800),
                'actual_assessement_dc' => $faker->numberBetween(200, 800),
                'actual_assessement_jc' => $faker->numberBetween(200, 800),
                'actual_assessement_adc' => $faker->numberBetween(200, 800),
                'actual_assessement_commissionar' => $faker->numberBetween(200, 800),
                'bill_assessement_aro' => $faker->numberBetween(800, 1500),
                'bill_assessement_ro' => $faker->numberBetween(800, 1500),
                'bill_assessement_ac' => $faker->numberBetween(800, 1500),
                'bill_assessement_dc' => $faker->numberBetween(800, 1500),
                'bill_assessement_jc' => $faker->numberBetween(800, 1500),
                'bill_assessement_adc' => $faker->numberBetween(800, 1500),
                'bill_assessement_commissionar' => $faker->numberBetween(800, 1500),
                'ie_data_id' => $faker->randomElement($ieDataIds),
                'total_paid' => $totalPaid,
                'payments' => $payments,
                'balance' => $balance,
            ]);
        }
    }
}
