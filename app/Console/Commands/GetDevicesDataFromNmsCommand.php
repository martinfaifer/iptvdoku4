<?php

namespace App\Console\Commands;

use App\Events\BroadcastDevicesMenuEvent;
use App\Models\Device;
use App\Services\Api\NMS\ConnectService;
use Illuminate\Console\Command;

class GetDevicesDataFromNmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devices:data-from-nms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting data from nms about devices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Device::where('ip', '!=', null)->each(function ($device) {
            (new ConnectService($device, 'search'))->connect();
        });

        BroadcastDevicesMenuEvent::dispatch();
    }
}
