<?php

namespace App\Jobs;

use App\Events\BroadcastAlertEvent;
use App\Models\Device;
use App\Models\Tag;
use App\Models\TagOnItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GpuDeviceCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $timeout = 600; // 10min timeout

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Tag::where('action', 1)->get()->each(function ($tag) {
            // search if tag has bound to device
            TagOnItem::where('type', 'device')->where('tag_id', $tag->id)->get()->each(function ($tagOnItem) {
                try {
                    CheckDeviceGpuJob::dispatch(Device::find($tagOnItem->item_id)->load('ssh'));
                } catch (\Throwable $th) {
                    //throw $th;
                }
            });
        });

        BroadcastAlertEvent::dispatch();
    }
}
