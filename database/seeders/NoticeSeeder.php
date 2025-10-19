<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notice;
use Carbon\Carbon;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notice::create([
            'title' => 'First Notice',
            'file_link' => '/storage/notices/sample1.pdf',
            'publish_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
            'archive_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
            'status' => 'active',
        ]);

        Notice::create([
            'title' => 'Second Notice',
            'file_link' => '/storage/notices/sample2.pdf',
            'publish_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
            'archive_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
            'status' => 'active',
        ]);

        Notice::create([
            'title' => 'Archived Notice',
            'file_link' => '/storage/notices/sample3.pdf',
            'publish_date' => Carbon::now()->subDays(30)->format('Y-m-d'),
            'archive_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
            'status' => 'archived',
        ]);
    }
}
