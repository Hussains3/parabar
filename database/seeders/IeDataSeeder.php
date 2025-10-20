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

        $districts = [
            'Bagerhat', 'Bandarban', 'Barguna', 'Barisal', 'Bhola', 'Bogra', 'Brahmanbaria',
            'Chandpur', 'Chittagong', 'Chuadanga', 'Comilla', "Cox'sBazar", 'Dhaka', 'Dinajpur',
            'Faridpur', 'Feni', 'Gaibandha', 'Gazipur', 'Gopalganj', 'Habiganj', 'Jamalpur',
            'Jessore', 'Jhenaidah', 'Khulna', 'Kishoreganj', 'Kurigram', 'Kushtia', 'Lakshmipur',
            'Madaripur', 'Magura', 'Manikganj', 'Maulvibazar', 'Meherpur', 'Munshiganj',
            'Mymensingh', 'Naogaon', 'Narail', 'Narayanganj', 'Narsingdi', 'Natore', 'Nawabganj',
            'Netrokona', 'Nilphamari', 'Noakhali', 'Pabna', 'Panchagarh', 'Patuakhali', 'Pirojpur',
            'Rajbari', 'Rajshahi'
        ];

        foreach (range(1, 50) as $index) {
            Ie_data::create([
                'org_name' => $faker->company,
                'org_logo' => null, // No fake images in seeder
                'bin_no' => 'BIN' . $faker->unique()->numberBetween(100000, 999999),
                'tin_no' => 'TIN' . $faker->unique()->numberBetween(100000, 999999),
                'name' => $faker->company . ' ' . $faker->randomElement(['Imports', 'Exports', 'Trading']),
                'fax_telephone' => $faker->phoneNumber,
                'phone_primary' => '+880' . $faker->numberBetween(1300000000, 1999999999),
                'phone_secondary' => '+880' . $faker->numberBetween(1300000000, 1999999999),
                'whatsapp' => '+880' . $faker->numberBetween(1300000000, 1999999999),
                'email_primary' => $faker->unique()->safeEmail,
                'email_secondary' => $faker->unique()->safeEmail,
                'house_distric' => $faker->randomElement($districts),
                'address' => $faker->streetAddress . ', ' . $faker->city,
                'post' => $faker->postcode,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }


    }
}
