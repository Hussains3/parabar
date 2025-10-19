<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\File_data;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FileDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Set date range from start of 2025 to today
        $startDate = '2025-01-01';
        $endDate = '2025-05-08'; // Today's date

        $ieDataIds = DB::table('ie_datas')->pluck('id')->toArray();// Get all existing IDs from the ie_datas table
        $agentIds = DB::table('agents')->pluck('id')->toArray();// Get all existing IDs from the agents table
        $operatorIds = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', 'operator')
            ->pluck('model_has_roles.model_id')
            ->toArray(); // Get IDs of users with operator role

        for ($i = 0; $i < 1000; $i++) {
            $createdAt = $faker->dateTimeBetween($startDate, $endDate);
            
            DB::table('file_datas')->insert([
                'lodgement_no' => $faker->randomNumber(4, true), // 4-digit number
                'lodgement_date' => $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'), // Random date
                'manifest_no' => $faker->randomNumber(4, true), // 4-digit number
                'manifest_date' => $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'), // Random date
                'group' => null, // Random word
                'ie_type' => null, // Random type
                'ie_group' => null,
                'goods_name' => null,
                'goods_type' => null,
                'be_number' => $faker->randomNumber(6, true), // 6-digit number
                'be_date' => $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d'),
                'fees' => $faker->randomFloat(2, 100, 10000), // Random float between 100 - 10000
                'page' => $faker->randomDigitNotNull(),
                'no_of_items' => $faker->numberBetween(1, 100),
                'status' => $faker->randomElement(['Received', 'Delivered','Printed']), // Random status
                'ie_data_id' => $faker->randomElement($ieDataIds), // Select a random ID from ie_datas
                'agent_id' => $faker->randomElement($agentIds),
                'reciver_id' => 12,
                'operator_id' => $faker->randomElement($operatorIds),
                'deliverer_id' => $faker->randomElement($operatorIds),
                'delivered_at' => null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

    }
}
