<?php

namespace App\Jobs;

use App\Actions\Devices\CheckCpuUsageAction;
use App\Models\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckDeviceCpuJob implements ShouldQueue
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
        (new CheckCpuUsageAction($this->device))();
    }
}
