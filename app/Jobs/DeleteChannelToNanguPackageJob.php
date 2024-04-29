<?php

namespace App\Jobs;

use App\Services\Api\NanguTv\ChannelPackagesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteChannelToNanguPackageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $channel_package_code,
        public $nangu_channel_code,
        public $nangu_isp_id
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new ChannelPackagesService())->delete(
            channel_package_code: $this->channel_package_code,
            nangu_channel_code: $this->nangu_channel_code,
            nangu_isp_id: $this->nangu_isp_id
        );
    }
}
