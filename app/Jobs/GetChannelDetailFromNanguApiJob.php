<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Api\NanguTv\ChannelsService;

class GetChannelDetailFromNanguApiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public object $channel, public $ttl)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // get information from nangu
            $nanguResponse = (new ChannelsService())->detail($this->channel->nangu_channel_code);
            // separate all informations about it and store to cache.

            // app order
            Cache::put('nangu_channel_' . $this->channel->id . '_app_order', [
                "order" => $nanguResponse['weight']
            ], $this->ttl);

            Cache::put('nangu_channel_' . $this->channel->id . '_timeshift', [
                "timeshift" => $nanguResponse['storedMediaDuration']
            ], $this->ttl);

            // store all result for future manipulation
            Cache::put('nangu_channel_' . $this->channel->id, $nanguResponse, $this->ttl);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
