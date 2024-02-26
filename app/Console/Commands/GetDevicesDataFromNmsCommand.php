<?php

namespace App\Console\Commands;

use App\Models\Device;
use Illuminate\Console\Command;
use App\Services\Api\NMS\ConnectService;

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
        Device::where('ip', "!=", null)->each(function ($device) {
            (new ConnectService($device, 'search'))->connect();
        });
    }
}
