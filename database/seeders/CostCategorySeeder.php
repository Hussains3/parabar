<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CostCategory;

class CostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Salaries'],
            ['name' => 'Electricity Bill',],
            ['name' => 'Internet Bill',],
            ['name' => 'Water Bill',],
            ['name' => 'Office Supplies'],
            ['name' => 'Office Rent'],
            ['name' => 'Guest'],
            ['name' => 'Other Expenses'],
        ];

        foreach ($categories as $category) {
            CostCategory::create($category);
        }
    }
}
