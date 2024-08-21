<?php

namespace App\Jobs;

use App\Actions\Slack\SendSlackNotificationAction;
use App\Mail\SendNotificationEmail;
use App\Models\IptvDohledUrl;
use App\Models\IptvDohledUrlsNotification;
use App\Models\Slack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendAlertForStreamWhichIsDownJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $cacheTimeout = 1800; // this is seconds

    /**
     * Create a new job instance.
     */
    public function __construct(public array $downStreams)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $defaultSlackChannel = Slack::where('action', 'crashed_channel')->first();
        if (blank($this->downStreams)) {
            return;
        }

        foreach ($this->downStreams as $downStream) {
            if (array_key_exists('strem_url', $downStream)) {
                $storedStream = IptvDohledUrl::where('stream_url', $downStream['strem_url'])->first();
                if ($storedStream) {
                    if ($storedStream->can_notify) {
                        // search if stream has custom notification channels
                        $customNotifications = IptvDohledUrlsNotification::where('iptv_dohled_url_id', $storedStream->id)->first();
                        if ($customNotifications) {
                            foreach (IptvDohledUrlsNotification::where('iptv_dohled_url_id', $storedStream->id)->get() as $notification) {
                                // check if is filled slack_channel
                                if (! blank($notification->slack_channel)) {
                                    if (! Cache::has('sended_slack_alert_'.$downStream['stream_url'].$notification->slack_channel)) {
                                        (new SendSlackNotificationAction(
                                            text: 'Nefunguje '.$downStream['nazev'].'s url '.$downStream['stream_url'],
                                            url: $notification->slack_channel
                                        ))();

                                        Cache::put('sended_slack_alert_'.$downStream['stream_url'].$notification->slack_channel, [], $this->cacheTimeout);
                                    }
                                }
                                // check if is filled email
                                if (! blank($notification->email)) {
                                    if (! Cache::has('sended_email_alert_'.$downStream['stream_url'].$notification->email)) {
                                        // email class need to be here
                                        Mail::to($notification->email)->queue(new SendNotificationEmail(
                                            emailSubject: 'Nefunguje '.$downStream['nazev'],
                                            emailContent: 'Nefunguje '.$downStream['nazev'].'s url '.$downStream['stream_url'],
                                        ));
                                        Cache::put('sended_email_alert_'.$downStream['stream_url'].$notification->email, [], $this->cacheTimeout);
                                    }
                                }
                            }
                        } else {
                            // send to default channel
                            if ($defaultSlackChannel) {
                                if (! Cache::has('sended_slack_alert_'.$downStream['stream_url'].$defaultSlackChannel->url)) {
                                    (new SendSlackNotificationAction(
                                        text: 'Nefunguje '.$downStream['nazev'].'s url '.$downStream['stream_url'],
                                        url: $defaultSlackChannel->url
                                    ))();

                                    Cache::put('sended_slack_alert_'.$downStream['stream_url'].$defaultSlackChannel->url, [], $this->cacheTimeout);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
