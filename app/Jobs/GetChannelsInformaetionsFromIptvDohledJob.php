<?php

namespace App\Jobs;

use App\Services\Api\IptvDohled\ConnectService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetChannelsInformaetionsFromIptvDohledJob implements ShouldQueue
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
        (new ConnectService(
            endpointType: 'get-stream-by-ip',
            params: str_contains($this->ip, ':1234') ? $this->ip : $this->ip.':1234'
        ))->connect(cacheKey: $this->ip);
    }
}