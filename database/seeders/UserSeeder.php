<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $admin = User::updateOrCreate(
                ['email' => 'admin@app.com'],
                [
                    'name' => 'Admin',
                    'password' => Hash::make('admin123'),
                ]
            );
            $admin->assignRole([$adminRole->id]);
        }

        // Create 20 staff users
        // $faker = Faker::create();
        // $staffRole = Role::where('name', 'staff')->first();

        
        // if ($staffRole) {
        //     for ($i = 1; $i <= 20; $i++) {
        //         $user = User::create([
        //             'name' => $faker->name,
        //             'email' => $faker->unique()->safeEmail,
        //             'password' => Hash::make('password123'),
        //             'phone' => str_replace(['-', ' ', '(', ')', '.'], '', $faker->phoneNumber),
        //             'staff_id_no' => 'STAFF-' . str_pad($i, 4, '0', STR_PAD_LEFT),
        //             'post' => substr($faker->jobTitle, 0, 50),
        //             'work_site' => $faker->city,
        //             'address' => str_replace(["\n", "\r"], ' ', $faker->streetAddress),
        //             'whatsapp' => str_replace(['-', ' ', '(', ')', '.'], '', $faker->phoneNumber),
        //             'date_of_birth' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
        //             'blood_group' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
        //             'father_name' => $faker->name('male'),
        //             'father_mobile' => str_replace(['-', ' ', '(', ')', '.'], '', $faker->phoneNumber),
        //             'mother_name' => $faker->name('female'),
        //             'mother_mobile' => str_replace(['-', ' ', '(', ')', '.'], '', $faker->phoneNumber),
        //             'wife_name' => $faker->optional(0.7)->name('female'),
        //             'wife_mobile' => $faker->optional(0.7) ? str_replace(['-', ' ', '(', ')', '.'], '', $faker->phoneNumber) : null,
        //             'home_address' => str_replace(["\n", "\r"], ' ', $faker->streetAddress),
        //             'ref_name' => $faker->name,
        //         ]);

        //         $user->assignRole([$staffRole->id]);
        //     }
        // }

    }
}
