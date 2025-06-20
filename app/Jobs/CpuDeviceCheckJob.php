<?php

namespace App\Jobs;

use App\Models\Tag;
use App\Models\Device;
use App\Models\TagOnItem;
use Illuminate\Bus\Queueable;
use App\Jobs\CheckDeviceCpuJob;
use App\Events\BroadcastAlertEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CpuDeviceCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
         Tag::where('action', 8)->get()->each(function ($tag) {
            // search if tag has bound to device
            TagOnItem::where('type', 'device')->where('tag_id', $tag->id)->get()->each(function ($tagOnItem) {
                try {
                    CheckDeviceCpuJob::dispatch(Device::find($tagOnItem->item_id)->load('ssh'));
                } catch (\Throwable $th) {
                    //throw $th;
                }
            });
        });

        BroadcastAlertEvent::dispatch();
    }
}
