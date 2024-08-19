<?php

namespace App\Jobs;

use App\Models\Chart;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Engines\Devices\SNMP\DeviceSnmpEngine;
use App\Traits\Devices\CheckDeviceInterfaceStatusTrait;

class GetSnmpDataFromDeviceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CheckDeviceInterfaceStatusTrait;

    /**
     * Create a new job instance.
     */
    public function __construct(public $device)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (str_contains(json_encode($this->device->template), 'snmp')) {
            // start the engine
            $snmpEngine = new DeviceSnmpEngine($this->device);
            // search in inputs
            $template = $this->device->template;

            if (array_key_exists('snmp', $template)) {
                foreach ($template['snmp'] as &$generalSnmp) {
                    if ($generalSnmp['type'] == 'read') {
                        $generalSnmp['value'] = $snmpEngine->get($generalSnmp['oid']);
                        if ($generalSnmp['can_chart'] == 1) {
                            Chart::create([
                                'item' => 'device:' . $this->device->id . ':' . $generalSnmp['human_description'],
                                'value' => (int) $generalSnmp['value'],
                            ]);
                        }
                    }
                }
            }

            if (array_key_exists('inputs', $template)) {
                foreach ($template['inputs'] as &$input) {
                    if (array_key_exists('snmp', $input)) {
                        foreach ($input['snmp'] as &$inputSnmp) {
                            if ($inputSnmp['type'] == 'read') {
                                $valueOid = $snmpEngine->get($inputSnmp['oid']);

                                if (str_contains($inputSnmp['human_description'], 'status')) {
                                    $this->check_interface_status(
                                        device: $this->device,
                                        newStatus: $valueOid,
                                        oldStatus: $inputSnmp['value'],
                                        interface: $inputSnmp['human_description']
                                    );
                                }

                                $inputSnmp['value'] = $valueOid;
                                if ($inputSnmp['can_chart'] == 1) {
                                    Chart::create([
                                        'item' => 'device:' . $this->device->id . ':' . $inputSnmp['human_description'],
                                        'value' => (int) $inputSnmp['value'],
                                    ]);
                                }
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
                                if ($outputSnmp['can_chart'] == 1) {
                                    Chart::create([
                                        'item' => 'device:' . $this->device->id . ':' . $outputSnmp['human_description'],
                                        'value' => (int) $outputSnmp['value'],
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            $this->device->update([
                'template' => $template,
            ]);
        }
    }
}
