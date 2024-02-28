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
        $schedule->command('iptv-dohled:alerts')->everyTwentySeconds();
        $schedule->command('devices:snmp-get')->everyFiveMinutes();
        $schedule->command('devices:data-from-nms')->everyThirtyMinutes();
        $schedule->command('channels:get-informartions-from-dohled')->everyMinute();
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
