<?php

namespace App\Jobs;

use App\Services\Logger\LoggerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $user,
        public string $type,
        public string $item,
        public $payload
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new LoggerService(
            user: $this->user,
            type: $this->type,
            item: $this->item,
            payload: $this->payload
        ))->log();
    }
}
