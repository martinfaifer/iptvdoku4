<?php

namespace App\Console\Commands;

use App\Models\Tag;
use App\Models\Device;
use App\Models\TagOnItem;
use App\Jobs\GetNimbleDataJob;
use App\Jobs\GpuDeviceCheckJob;
use Illuminate\Console\Command;
use App\Events\BroadcastAlertEvent;
use App\Actions\Devices\GetNimbleDataAction;
use App\Actions\Devices\CheckIfGpuWorkingAction;

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
        GpuDeviceCheckJob::dispatch();

        // nimble actions
        // get all devices on nimble api and bound ids
        GetNimbleDataJob::dispatch();
    }
}
