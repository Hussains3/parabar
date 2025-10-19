<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            \Log::info('Scheduled task started: Deleting old activity logs.');
            \App\Models\ActivityLog::where('created_at', '<', now()->subWeek())->delete();
            \Log::info('Scheduled task completed: Old activity logs deleted.');
        })->daily();
    }
}
