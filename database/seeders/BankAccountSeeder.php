<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;
use App\Models\BankAccount;
use Faker\Factory as Faker;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $banks = Bank::all(); // Fetch all existing banks

        foreach ($banks as $bank) {
            // Create 3 bank accounts per bank
            for ($i = 0; $i < 1; $i++) {
                BankAccount::create([
                    'bank_id' => $bank->id,
                    'account_number' => $faker->unique()->bankAccountNumber,
                    'account_holder_name' => $faker->optional()->name,
                    'balance' => $faker->randomFloat(2, 1000, 100000), // Random balance between 1,000 and 100,000
                ]);
            }
        }
    }
}
