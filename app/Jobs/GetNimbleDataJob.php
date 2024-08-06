<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Events\BroadcastAlertEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Actions\Devices\GetNimbleDataAction;

class GetNimbleDataJob implements ShouldQueue
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
        (new GetNimbleDataAction())();
        BroadcastAlertEvent::dispatch();
    }
}
