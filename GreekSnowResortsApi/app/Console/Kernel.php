<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:delete-old-records')->everyMinute();
        $schedule->command('app:isopen')->everyTenMinutes();
        $schedule->command('app:run-update-snow-report-task')->hourly() ;
        $schedule->command('sanctum:prune-expired --hours=24')->daily();
//        $schedule->command('app:get-facebook-posts')->daily();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
