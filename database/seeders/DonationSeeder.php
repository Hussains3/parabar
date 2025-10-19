<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donation; // Import the Donation model
use Faker\Factory as Faker;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            Donation::create([
                'date' => $faker->date(),
                'purpose' => $faker->sentence(3), // Random purpose
                'amount' => $faker->randomFloat(2, 10, 1000), // Random amount between 10 and 1000
                'agent_id' => $faker->numberBetween(1, 10), // Assuming agent IDs range from 1 to 10
                'type' => $faker->randomElement(['Treatment', 'Education', 'Marrige']), // Random type
                'status' => $faker->randomElement(['Pending', 'Approved', 'Rejected']), // Random status
            ]);
        }
    }
}
