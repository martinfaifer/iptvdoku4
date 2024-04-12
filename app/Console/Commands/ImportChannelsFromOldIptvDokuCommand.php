<?php

namespace App\Console\Commands;

use App\Models\Channel;
use App\Models\ChannelCategory;
use App\Models\ChannelMulticast;
use App\Models\ChannelQualityWithIp;
use App\Models\ChannelSource;
use App\Models\H264;
use App\Models\H265;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportChannelsFromOldIptvDokuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:channels-from-old-iptv-doku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all channels from old version of iptv doku';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $responseJson = Http::withBasicAuth(config('services.api.4.old_iptv_doku.user'), config('services.api.4.old_iptv_doku.password'))
            ->get(config('services.api.4.old_iptv_doku.url') . "/api/v1/channels")->json();

        foreach ($responseJson['data'] as $channel) {
            $path = null;
            if (!is_null($channel['logo'])) {
                $logo = str_replace("//", "/", $channel['logo']);
                $explodedLogo = explode("/", $logo);
                if (array_key_exists(4, $explodedLogo)) {
                    $path = "public/Logos/" . $explodedLogo[4];
                }
            }

            $storedChannel = Channel::where('name', $channel['name'])->first();
            if (!$storedChannel) {
                $storedChannel = Channel::create([
                    'name' => $channel['name'],
                    'logo' => $path,
                    'is_radio' => $channel['is_radio'] == true ? true : false,
                    'is_multiscreen' => $channel['is_multiscreen'] == true ? true : false,
                    'quality' => is_null($channel['quality']) ? "SD" : $channel['quality'],
                    'category' => is_null($channel['category']) ? null : ChannelCategory::where('name', $channel['category'])->first()->id,
                    'description' => $channel['description'],
                ]);
            }

            // create multicasts
            $storedMulticast = ChannelMulticast::where('channel_id', $storedChannel->id)->first();
            if (!$storedMulticast) {
                foreach ($channel['multicasts'] as $multicast) {
                    // dd($multicast['multicast_source']['zdroj']);
                    $isBackup = false;
                    if ($multicast['isBackup'] == "yes") {
                        $isBackup = true;
                    }

                    if (ChannelMulticast::where('stb_ip', $multicast['stb_ip'])->first()) {
                        $storedMulticast = ChannelMulticast::create([
                            'channel_id' => $storedChannel->id,
                            'source_ip' => $multicast['multicast_ip'],
                            'channel_source_id' => ChannelSource::where('name', $multicast['multicast_source']['zdroj'])->first()->id,
                            'is_backup' => $isBackup
                        ]);
                    } else {
                        $storedMulticast = ChannelMulticast::create([
                            'channel_id' => $storedChannel->id,
                            'stb_ip' => $multicast['stb_ip'],
                            'source_ip' => $multicast['multicast_ip'],
                            'channel_source_id' => ChannelSource::where('name', $multicast['multicast_source']['zdroj'])->first()->id,
                            'is_backup' => $isBackup
                        ]);
                    }
                }
            }

            // create h264 and h265
            // need $storedChannel
            if (!is_null($channel['h264'])) {
                if (!H264::where('channel_id', $storedChannel->id)->first()) {
                    $h264 = H264::create([
                        'channel_id' => $storedChannel->id
                    ]);

                    // add h264 data
                    foreach ($channel['h264']['outputs'] as $output) {
                        try {
                            ChannelQualityWithIp::create([
                                'h264_id' => $h264->id,
                                'channel_quality_id' =>  $this->findQuality($output['kvalitaId']),
                                'ip' => $output['output']
                            ]);
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                    }
                }
            }

            if (!is_null($channel['h265'])) {
                if (!H265::where('channel_id', $storedChannel->id)->first()) {
                    $h265 = H265::create([
                        'channel_id' => $storedChannel->id
                    ]);

                    // add h265 data
                    foreach ($channel['h265']['outputs'] as $output) {
                        try {
                            ChannelQualityWithIp::create([
                                'h265_id' => $h265->id,
                                'channel_quality_id' =>  $this->findQuality($output['kvalitaId']),
                                'ip' => $output['output']
                            ]);
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                    }
                }
            }
        }
    }

    protected function findQuality($oldQualityId)
    {
        if ($oldQualityId == 1) {
            return 1;
        }

        if ($oldQualityId == 2) {
            return 2;
        }

        if ($oldQualityId == 3) {
            return 3;
        }

        if ($oldQualityId == 4) {
            return 5;
        }

        if ($oldQualityId == 5) {
            return 6;
        }

        if ($oldQualityId == 6) {
            return 4;
        }
    }
}
