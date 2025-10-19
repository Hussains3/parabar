<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ie_data;
use Illuminate\Support\Str;

class IeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 50) as $index) {
            Ie_data::create([
                'bin_no' => Str::random(10), // Random BIN number
                'ie' => $faker->randomElement(['Import', 'Export']), // Randomly "Import" or "Export"
                'name' => $faker->company, // Fake company name
                'owners_name' => $faker->name, // Fake owner's name
                'photo' => $faker->imageUrl(100, 100, 'business', true, 'owner'), // Fake image URL
                'destination' => $faker->city, // Fake city name
                'office_address' => $faker->address, // Fake address
                'phone' => $faker->phoneNumber, // Fake phone number
                'email' => $faker->unique()->safeEmail, // Fake unique email
                'house' => $faker->buildingNumber, // Fake building number
                'created_at' => now(), // Current timestamp
                'updated_at' => now(), // Current timestamp
            ]);
        }


    }
}
