<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    // protected function schedule(Schedule $schedule): void
    // {
    //     // Corrected to use everyMinute() instead of everyMinutes()
    //     $schedule->command('app:notify-unaccepted-orders')->everySecond();
    // }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }


    protected function schedule(Schedule $schedule)
{

    $schedule->call(function () {
        Log::info('Cron is running at ' . now());
    })->everyMinute();
}


}
