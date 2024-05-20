<?php

namespace App\Jobs;

use App\Actions\Slack\SendSlackNotificationAction;
use App\Models\Slack;
use App\Services\Api\IptvDohled\ConnectService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class GetAlertsFromIptvDohledJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $errorStreams = (new ConnectService('alerts'))->connect('iptv_dohled_alerts');
        // check how many streams are down and send notification to slack
        if (count($errorStreams) >= 10) {
            // need too slow down process for spaming in slack channel
            if (!Cache::has('sended_error_notification_about_high_channels_down')) {
                $slack = Slack::where('action', 'crashed_channel')->first();
                if ($slack) {
                    (new SendSlackNotificationAction(
                        text: 'Nefunguje ' . count($errorStreams) . ' streamů',
                        url: $slack->url
                    ))();

                    Cache::put('sended_error_notification_about_high_channels_down', [], 600);
                }
            }

            SendEmailNotificationJob::dispatch(
                "Vysoké množství nefunkčních kanálů",
                "Nefunguje více jak 10 kanálů v IPTV dohledu",
                null,
                'notify_if_too_many_channels_down'
            );
            // notify_if_too_many_channels_down
        }
    }
}
