<?php

namespace App\Jobs;

use App\Models\IptvDohledUrl;
use App\Models\IptvDohledUrlsNotification;
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
        $streamInDohled = IptvDohledUrl::where('stream_url', $this->ip)->first();
        (new ConnectService(
            endpointType: 'delete-stream',
            params: $streamInDohled->iptv_dohled_id
        ))->connect();

        // remove custom notifications if are
        try {
            IptvDohledUrlsNotification::where('iptv_dohled_url_id', $streamInDohled->id)->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
        // remove stream from table
        $streamInDohled->delete();
    }
}
