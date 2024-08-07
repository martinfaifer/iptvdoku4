<?php

namespace App\Jobs;

use App\Models\Tag;
use App\Models\Device;
use App\Models\TagOnItem;
use Illuminate\Bus\Queueable;
use App\Events\BroadcastAlertEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Actions\Devices\CheckIfGpuWorkingAction;

class GpuDeviceCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $timeout = 600; // 10min timeout

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
                    (new CheckIfGpuWorkingAction(Device::find($tagOnItem->item_id)->load('ssh')))();
                } catch (\Throwable $th) {
                    //throw $th;
                }
            });
        });

        BroadcastAlertEvent::dispatch();
    }
}
