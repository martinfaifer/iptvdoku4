<?php

namespace App\Engines\Devices\Templates;

use App\Models\Device;
use Illuminate\Support\Str;
use App\Models\DeviceTemplate;
use App\Models\DeviceVendorSnmp;
use App\Engines\Devices\Templates\Traits\InterfaceGeneratorTrait;

class DeviceTemplateEngine
{
    use InterfaceGeneratorTrait;

    public array $template = [];

    public function generate(Device $device, array|null $inputs = null, array|null $outputs = null, array|null $modules = null): bool
    {
        if (!is_null($inputs) || $inputs['numberOfInInterfaces'] != 0) {
            for ($i = 1; $i <= $inputs['numberOfInInterfaces']; $i++) {
                $this->template['inputs']['input_' . $i] = $this->generate_interface(
                    interfaceData: $inputs,
                    interfaceNumber: $i,
                    deviceVendorId: $device->device_vendor_id,
                    interfaceType: "input"
                );
            }
        }

        if (!is_null($outputs) || $outputs['numberOfOutInterfaces'] != 0) {
            for ($i = 1; $i <= $outputs['numberOfOutInterfaces']; $i++) {
                $this->template['outputs']['output_' . $i] = $this->generate_interface(
                    interfaceData: $outputs,
                    interfaceNumber: $i,
                    deviceVendorId: $device->device_vendor_id,
                    interfaceType: "output"
                );
            }
        }

        if (!is_null($modules) || $modules['numberOfModules'] != 0) {
            for ($i = 1; $i <= $modules['numberOfModules']; $i++) {
                $this->template['modules']['modul_' . $i] = $this->generate_interface(
                    interfaceData: $modules,
                    interfaceNumber: $i,
                    deviceVendorId: $device->device_vendor_id,
                    interfaceType: "modul"
                );
            }
        }

        $snmps = DeviceVendorSnmp
            ::where('device_vendor_id', $device->device_vendor_id)
            ->where('interface', null)
            ->get();

        if (!$snmps->isEmpty()) {
            foreach ($snmps as $snmp) {
                $this->template['snmp'][] = [
                    'oid' => $snmp->oid,
                    'human_description' => $snmp->human_description,
                    'value' => "",
                    'type' => $snmp->type,
                    'can_chart' => $snmp->can_chart
                ];
            }
        }

        $templateName = explode(" ", $device->name);

        DeviceTemplate::create([
            'name' => $templateName[0] . "_" . Str::random(5),
            'template' => $this->template
        ]);

        $device->update([
            'template' => $this->template
        ]);

        return true;
    }

    public function update(Device $device, $updatedInterface, $updatedInterfaceType, $updatedInterfaceKey): bool
    {
        $template = $device->template;
        $template[$updatedInterfaceType][$updatedInterfaceKey] =  $updatedInterface;
        $device->update([
            'template' => $template
        ]);

        return true;
    }
}
