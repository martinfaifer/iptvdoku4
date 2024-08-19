<?php

namespace App\Console\Commands;

use App\Jobs\GetSnmpDataFromDeviceJob;
use App\Models\Device;
use Illuminate\Console\Command;

class GetSnmpDataFromDevicesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devices:snmp-get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting data from devices via snmp connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $templateKeys = ['inputs', 'outputs', 'snmp'];

        $devices = Device::where('template', '!=', null)->get();

        if ($devices->isEmpty()) {
            exit();
        }

        $devices->each(function ($device) {
            GetSnmpDataFromDeviceJob::dispatch($device);
        });
    }
}
