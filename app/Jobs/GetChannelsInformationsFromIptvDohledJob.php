<?php

namespace App\Jobs;

use App\Models\ChannelQualityWithIp;
use App\Models\IptvDohledUrl;
use App\Services\Api\IptvDohled\ConnectService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetChannelsInformationsFromIptvDohledJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $port = ":1234";

    /**
     * Create a new job instance.
     */
    public function __construct(public string $ip)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = (new ConnectService(
            endpointType: 'get-stream-by-ip',
            params: str_contains($this->ip, $this->port) ? $this->ip : $this->ip . $this->port
        ))->connect(cacheKey: $this->ip);

        if (! is_null($response)) {
            try {

                if ($response['status'] == 'success') {
                    if (! IptvDohledUrl::where('stream_url', $this->ip)
                        ->first()) {
                        IptvDohledUrl::create([
                            'iptv_dohled_id' => $response['data']['streamId'],
                            'stream_url' => $this->ip,
                        ]);
                    }

                    // find min max video bitrate to ip
                    $ipWithQuality = ChannelQualityWithIp::where('ip', $this->ip)->with('channelQuality')->first();
                    if ($ipWithQuality) {
                        $maxBitrate = $ipWithQuality->channelQuality->bitrate / 1000; // Mbps
                        $maxBitrate = $maxBitrate * 2; //
                        foreach ($response['data']['videoCharts'] as $videoPid) {
                            foreach (array_reverse($videoPid['seriesData'][0]['data']) as $key => $bitrate) {
                                if (round($bitrate, 1) >= $maxBitrate) {
                                    $problemedBitrates[] = round($bitrate, 1);
                                }
                                if ($key == 2) {
                                    break;
                                }
                            }
                        }

                        if (isset($problemedBitrates)) {
                            if (count($problemedBitrates) == 3) {
                                // send to queue for sending alerts
                                SendAlertForStreamWhichHasHighBanwidth::dispatch(
                                    $this->ip,
                                    $problemedBitrates,
                                    $maxBitrate
                                );
                            }
                        }
                    }
                }
            } catch (\Throwable $th) {
                // info($this->ip, [$th]);
                // log  this exception
            }
        }
    }
}
