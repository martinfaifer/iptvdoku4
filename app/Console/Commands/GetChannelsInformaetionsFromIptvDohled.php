<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ChannelMulticast;
use App\Models\ChannelQualityWithIp;
use App\Services\Api\IptvDohled\ConnectService;

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
            (new ConnectService(
                endpointType: 'get-stream-by-ip',
                params: str_contains($multicast->stb_ip, ':1234') ? $multicast->stb_ip : $multicast->stb_ip . ":1234"
            ))->connect(cacheKey: $multicast->stb_ip);
        });

        // h264s && h265s
        ChannelQualityWithIp::get()->each(function ($unicast) {
            (new ConnectService(
                endpointType: 'get-stream-by-ip',
                params: str_contains($unicast->ip, ':1234') ? $unicast->ip : $unicast->ip . ":1234"
            ))->connect(cacheKey: $unicast->ip);
        });
    }
}
