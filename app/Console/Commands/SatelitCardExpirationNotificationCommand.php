<?php

namespace App\Console\Commands;

use App\Actions\Slack\SendSlackNotificationAction;
use App\Models\SatelitCard;
use App\Models\Slack;
use Illuminate\Console\Command;

class SatelitCardExpirationNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'satelitcards:expiration-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send slack notification if Satelit card will be soon expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (Slack::satelitcardExpiration()->first()) {
            foreach (Slack::satelitcardExpiration()->get() as $slackChannel) {
                if (SatelitCard::where('expiration', now()->addDays(7)->format("Y-m-d"))->first()) {
                    foreach (SatelitCard::where('expiration', now()->addDays(7)->format("Y-m-d"))->get() as $cardWithExpiration) {
                        (new SendSlackNotificationAction(
                            text: ":warning: Satelitní karta {$cardWithExpiration->name} bude expirovat ".now()->addDays(7)->format("d.m. Y")." !",
                            url: $slackChannel->url
                        ))();
                    }
                }
            }
        }
    }
}
