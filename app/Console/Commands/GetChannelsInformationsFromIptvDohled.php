<?php

namespace App\Console\Commands;

use App\Jobs\GetChannelsInformationsFromIptvDohledJob;
use App\Models\ChannelMulticast;
use App\Models\ChannelQualityWithIp;
use Illuminate\Console\Command;

class GetChannelsInformationsFromIptvDohled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channels:get-informations-from-dohled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting informations about channels from iptv dohled';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // multicasts
        ChannelMulticast::get()->each(function ($multicast) {
            if (! is_null($multicast->stb_ip)) {
                GetChannelsInformationsFromIptvDohledJob::dispatch($multicast->stb_ip);
            }
        });

        // h264s && h265s
        ChannelQualityWithIp::get()->each(function ($unicast) {
            GetChannelsInformationsFromIptvDohledJob::dispatch($unicast->ip);
        });
    }
}
