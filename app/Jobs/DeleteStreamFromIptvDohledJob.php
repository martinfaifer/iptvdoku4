<?php

namespace App\Jobs;

use App\Models\IptvDohledUrl;
use App\Services\Api\IptvDohled\ConnectService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteStreamFromIptvDohledJob implements ShouldQueue
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
            endpointType: 'delete-stream',
            params: IptvDohledUrl::where('stream_url', $this->ip)->first()->iptv_dohled_id
        ))->connect();

        // remove stream from table
        IptvDohledUrl::where('stream_url', $this->ip)->delete();
    }
}
