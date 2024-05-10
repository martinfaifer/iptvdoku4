<?php

namespace App\Jobs;

use App\Models\IptvDohledUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Events\BroadcastUpdateMulticastEvent;
use App\Models\ChannelMulticast;
use App\Services\Api\IptvDohled\ConnectService;

class StoreStreamToIptvDohledJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $name, public string $ip)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = (new ConnectService(
            endpointType: 'store-stream',
            formData: [
                'nazev' => $this->name,
                'stream_url' => str_contains($this->ip, ':1234') ? $this->ip : $this->ip . ':1234',
            ]
        ))->connect();

        if (!empty($response)) {
            IptvDohledUrl::create([
                'iptv_dohled_id' => $response['id'],
                'stream_url' => $this->ip
            ]);
        }
    }
}
