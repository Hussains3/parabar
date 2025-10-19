<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            ['name' => 'Sonali Bank Limited'],
            ['name' => 'Janata Bank Limited'],
            ['name' => 'Agrani Bank Limited'],
            ['name' => 'Rupali Bank Limited'],
            ['name' => 'Bangladesh Development Bank Limited'],
            ['name' => 'Pubali Bank Limited'],
            ['name' => 'Uttara Bank Limited'],
            ['name' => 'Islami Bank Bangladesh Limited'],
            ['name' => 'AB Bank Limited'],
            ['name' => 'Dutch-Bangla Bank Limited'],
            ['name' => 'BRAC Bank Limited'],
            ['name' => 'Eastern Bank Limited'],
            ['name' => 'National Bank Limited'],
            ['name' => 'Prime Bank Limited'],
            ['name' => 'NCC Bank Limited'],
            ['name' => 'Mercantile Bank Limited'],
            ['name' => 'South Bangla Agriculture and Commerce Bank Limited'],
            ['name' => 'Mutual Trust Bank Limited'],
            ['name' => 'Standard Bank Limited'],
            ['name' => 'IFIC Bank Limited'],
            ['name' => 'Bank Asia Limited'],
            ['name' => 'The City Bank Limited'],
            ['name' => 'Trust Bank Limited'],
            ['name' => 'Jamuna Bank Limited'],
            ['name' => 'One Bank Limited'],
            ['name' => 'EXIM Bank Limited'],
            ['name' => 'Al-Arafah Islami Bank Limited'],
            ['name' => 'Social Islami Bank Limited'],
            ['name' => 'Modhumoti Bank Limited'],
            ['name' => 'NRB Commercial Bank Limited'],
            ['name' => 'Meghna Bank Limited'],
            ['name' => 'Midland Bank Limited'],
            ['name' => 'Union Bank Limited'],
            ['name' => 'Global Islamic Bank Limited'],
            ['name' => 'Standard Chartered Bank'],
            ['name' => 'HSBC Bank'],
            ['name' => 'Citibank N.A.'],
            ['name' => 'State Bank of India'],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
