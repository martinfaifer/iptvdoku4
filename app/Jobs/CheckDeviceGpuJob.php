<?php

namespace App\Jobs;

use App\Actions\Devices\CheckIfGpuWorkingAction;
use App\Models\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckDeviceGpuJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Device $device)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new CheckIfGpuWorkingAction($this->device))();
    }
}
