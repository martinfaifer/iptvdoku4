<?php

namespace App\Jobs;

use App\Services\Api\NanguTv\ChannelsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

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
        // try {
        // get information from nangu
        $nanguResponse = (new ChannelsService())->detail($this->channel->nangu_channel_code);
        // separate all informations about it and store to cache.
        // app order
        if (array_key_exists('weight', $nanguResponse)) {
            Cache::put('nangu_channel_'.$this->channel->id.'_app_order', [
                'order' => $nanguResponse['weight'],
            ], $this->ttl);
        }

        if (array_key_exists('storedMediaDuration', $nanguResponse)) {
            Cache::put('nangu_channel_'.$this->channel->id.'_timeshift', [
                'timeshift' => $nanguResponse['storedMediaDuration'],
            ], $this->ttl);
        }

        // store all result for future manipulation
        Cache::put('nangu_channel_'.$this->channel->id, $nanguResponse, $this->ttl);
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    }
}
