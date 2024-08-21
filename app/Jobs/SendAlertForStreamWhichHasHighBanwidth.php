<?php

namespace App\Jobs;

use App\Models\Slack;
use App\Models\IptvDohledUrl;
use Illuminate\Bus\Queueable;
use App\Mail\SendNotificationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\IptvDohledUrlsNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Actions\Slack\SendSlackNotificationAction;

class SendAlertForStreamWhichHasHighBanwidth implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $cacheTimeout = 180; // this is seconds
    /**
     * Create a new job instance.
     */
    public function __construct(public string $stream_url, public array $highBanwidt, public string|int $maxAllowedBanwidth)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $monitoredStream = IptvDohledUrl::where('stream_url', $this->stream_url)->first();
        if (!$monitoredStream || !$monitoredStream->can_notify) {
            return;
        }

        $defaultSlackChannel = Slack::where('action', 'crashed_channel')->first();
        $customNotifications = IptvDohledUrlsNotification::where('iptv_dohled_url_id', $monitoredStream->id)->first();
        if ($customNotifications) {
            foreach (IptvDohledUrlsNotification::where('iptv_dohled_url_id', $monitoredStream->id)->get() as $notification) {
                // check if is filled slack_channel
                if (!blank($notification->slack_channel)) {
                    if (!Cache::has('sended_slack_alert_high_banwidth_' . $this->stream_url . $notification->slack_channel)) {
                        (new SendSlackNotificationAction(
                            text: "Stream  " . $this->stream_url . "má datový tok " . implode(", ", $this->highBanwidt) . " který je vyšší než povolený maximální " . $this->maxAllowedBanwidth,
                            url: $notification->slack_channel
                        ))();

                        Cache::put('sended_slack_alert_high_banwidth_' . $this->stream_url . $notification->slack_channel, [], $this->cacheTimeout);
                    }
                }
                // check if is filled email
                if (!blank($notification->email)) {
                    if (!Cache::has('sended_email_alert_high_banwidth_' .  $this->stream_url . $notification->email)) {
                        // email class need to be here
                        Mail::to($notification->email)->queue(new SendNotificationEmail(
                            emailSubject: "Stream " . $this->stream_url . " má vyšší datový tok",
                            emailContent: "Stream  " . $this->stream_url . " má datový tok " . implode(", ", $this->highBanwidt) . " který je vyšší než povolený maximální " . round($this->maxAllowedBanwidth, 1),
                        ));
                        Cache::put('sended_email_alert_high_banwidth_' .  $this->stream_url . $notification->email, [], $this->cacheTimeout);
                    }
                }
            }
        } else {
            // send to default channel
            if ($defaultSlackChannel) {
                if (!Cache::has('sended_slack_alert_high_banwidth_' . $this->stream_url . $defaultSlackChannel->url)) {
                    (new SendSlackNotificationAction(
                        text: "Stream  " . $this->stream_url . "má datový tok " . implode(", ", $this->highBanwidt) . " který je vyšší než povolený maximální " . $this->maxAllowedBanwidth,
                        url: $defaultSlackChannel->url
                    ))();

                    Cache::put('sended_slack_alert_high_banwidth_' . $this->stream_url . $defaultSlackChannel->url, [], $this->cacheTimeout);
                }
            }
        }
    }
}
