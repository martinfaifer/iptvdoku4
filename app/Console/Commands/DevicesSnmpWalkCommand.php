<?php

namespace App\Console\Commands;

use App\Engines\Devices\SNMP\DeviceSnmpEngine;
use App\Models\Device;
use Illuminate\Console\Command;

class DevicesSnmpWalkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devices:snmp-walk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Snmp walk for devices';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Device::where('is_snmp', true)->each(function ($device) {
            (new DeviceSnmpEngine($device))->snmp_walk();
        });
    }
}
