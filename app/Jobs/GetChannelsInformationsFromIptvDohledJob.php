<?php

namespace App\Jobs;

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
            params: str_contains($this->ip, ':1234') ? $this->ip : $this->ip.':1234'
        ))->connect(cacheKey: $this->ip);

        try {
            if ($response['status'] == 'success') {
                if (! IptvDohledUrl::where('iptv_dohled_id', $response['data']['streamId'])
                    ->where('stream_url', $this->ip)
                    ->first()) {
                    IptvDohledUrl::create([
                        'iptv_dohled_id' => $response['data']['streamId'],
                        'stream_url' => $this->ip,
                    ]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
