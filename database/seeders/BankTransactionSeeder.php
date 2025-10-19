<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankTransaction;
use App\Models\BankAccount;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

class BankTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $bankAccounts = BankAccount::all();

        foreach ($bankAccounts as $account) {
            // Create 5 transactions per account
            for ($i = 0; $i < 2; $i++) {
                $transaction = BankTransaction::create([
                    'bank_account_id' => $account->id,
                    'txn_number' => $faker->unique()->numerify('TXN-#####'),
                    'type' => $faker->randomElement(['deposit', 'withdrawal']),
                    'amount' => $faker->randomFloat(2, 100, 5000),
                    'note' => $faker->optional()->sentence,
                    'transaction_date' => $faker->dateTimeThisYear,
                ]);

                // Soft delete 1 out of 5 transactions
                if ($i === 0) {
                    $transaction->delete();
                }
            }
        }
    }
}
