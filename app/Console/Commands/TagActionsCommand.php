<?php

namespace App\Console\Commands;

use App\Actions\Devices\CheckIfGpuWorkingAction;
use App\Actions\Devices\GetNimbleDataAction;
use App\Events\BroadcastAlertEvent;
use App\Models\Device;
use App\Models\Tag;
use App\Models\TagOnItem;
use Illuminate\Console\Command;

class TagActionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tag:execute-actions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute actions belongs to tags';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // check if gpus working action 1
        Tag::where('action', 1)->get()->each(function ($tag) {
            // search if tag has bound to device
            TagOnItem::where('type', 'device')->where('tag_id', $tag->id)->get()->each(function ($tagOnItem) {
                rescue(function () use ($tagOnItem) {
                    (new CheckIfGpuWorkingAction(Device::find($tagOnItem->item_id)->load('ssh')))();
                });
            });
        });

        // nimble actions
        // get all devices on nimble api and bound ids
        (new GetNimbleDataAction())();

        BroadcastAlertEvent::dispatch();
    }
}
