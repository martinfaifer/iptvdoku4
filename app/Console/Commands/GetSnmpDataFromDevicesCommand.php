<?php

namespace App\Console\Commands;

use App\Engines\Devices\SNMP\DeviceSnmpEngine;
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
    protected $description = 'Command description';

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
            if (str_contains(json_encode($device->template), 'snmp')) {
                // start the engine
                $snmpEngine = new DeviceSnmpEngine($device);
                // search in inputs
                $template = $device->template;

                if (array_key_exists('snmp', $template)) {
                    foreach ($template['snmp'] as &$generalSnmp) {
                        if ($generalSnmp['type'] == 'read') {
                            $generalSnmp['value'] = $snmpEngine->get($generalSnmp['oid']);
                        }
                    }
                }

                if (array_key_exists('inputs', $template)) {
                    foreach ($template['inputs'] as &$input) {
                        if (array_key_exists('snmp', $input)) {
                            foreach ($input['snmp'] as &$inputSnmp) {
                                if ($inputSnmp['type'] == 'read') {
                                    $inputSnmp['value'] = $snmpEngine->get($inputSnmp['oid']);
                                }
                            }
                        }
                    }
                }

                if (array_key_exists('outputs', $template)) {
                    foreach ($template['outputs'] as &$output) {
                        if (array_key_exists('snmp', $output)) {
                            foreach ($output['snmp'] as &$outputSnmp) {
                                if ($outputSnmp['type'] == 'read') {
                                    $outputSnmp['value'] = $snmpEngine->get($outputSnmp['oid']);
                                }
                            }
                        }
                    }
                }

                $device->update([
                    'template' => $template
                ]);
            }
        });
    }
}
