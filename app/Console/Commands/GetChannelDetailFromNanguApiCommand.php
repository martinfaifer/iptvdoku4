<?php

namespace App\Console\Commands;

use App\Models\Channel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Services\Api\NanguTv\ChannelsService;

class GetChannelDetailFromNanguApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channels:get-detail-from-nangu-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting channels details from nangu api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ttl = 3600;

        Channel::get()->each(function ($channel) use ($ttl) {
            rescue(function () use ($channel, $ttl) {
                // get information from nangu
                $nanguResponse = (new ChannelsService())->detail($channel->nangu_channel_code);
                // separate all informations about it and store to cache.

                // app order
                Cache::put('nangu_channel_' . $channel->id . '_app_order', [
                    "order" => $nanguResponse['weight']
                ], $ttl);

                Cache::put('nangu_channel_' . $channel->id . '_timeshift', [
                    "timeshift" => $nanguResponse['storedMediaDuration']
                ], $ttl);

                // store all result for future manipulation
                Cache::put('nangu_channel_' . $channel->id, $nanguResponse, $ttl);
            });
        });
    }
}
