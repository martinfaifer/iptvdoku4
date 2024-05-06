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
        $schedule->command('model:prune')->daily();
        $schedule->command('horizon:clear')->daily();
        $schedule->command('php artisan queue:flush')->daily();

        $schedule->command('channel:restart')->dailyAt('03:00');

        $schedule->command('calendar:start-daily-event')->daily();
        $schedule->command('calendar:end-daily-event')->daily();
        $schedule->command('calendar:start-event')->everyMinute();
        $schedule->command('calendar:end-event')->everyMinute();

        $schedule->command('iptv-dohled:alerts')->everyTwentySeconds();

        $schedule->command('devices:data-from-nms')->everyFifteenMinutes()->runInBackground();
        $schedule->command('devices:snmp-get')->everyFiveMinutes()->runInBackground();

        $schedule->command('tag:execute-actions')->everyFiveMinutes()->runInBackground();

        $schedule->command('channels:get-detail-from-nangu-api')->everyFifteenMinutes();
        $schedule->command('channels:get-informations-from-dohled')->everyMinute();

        $schedule->command('epg:get-channels-ids')->everyThirtyMinutes()->runInBackground();

        $schedule->command('weather:get')->everyThirtyMinutes();

        $schedule->command('nangu:get-monthly-report')->monthly();

        $schedule->command('grape_transcoders:get_transcoders')->everyFifteenMinutes();

        $schedule->command('floweye:get-active-tickets')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
