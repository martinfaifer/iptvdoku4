<?php

namespace App\Console\Commands;

use App\Jobs\GetChannelsInformaetionsFromIptvDohledJob;
use App\Models\ChannelMulticast;
use App\Models\ChannelQualityWithIp;
use Illuminate\Console\Command;

class GetChannelsInformaetionsFromIptvDohled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channels:get-informartions-from-dohled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting informations about channels from iptv dohled';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // multicasts
        ChannelMulticast::get()->each(function ($multicast) {
            GetChannelsInformaetionsFromIptvDohledJob::dispatch($multicast->stb_ip);
        });

        // h264s && h265s
        ChannelQualityWithIp::get()->each(function ($unicast) {
            GetChannelsInformaetionsFromIptvDohledJob::dispatch($unicast->ip);
        });
    }
}
