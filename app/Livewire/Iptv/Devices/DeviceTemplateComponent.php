<?php

namespace App\Livewire\Iptv\Devices;

use App\Engines\Devices\SNMP\DeviceSnmpEngine;
use App\Engines\Devices\Templates\DeviceTemplateEngine;
use App\Models\Chart;
use App\Models\Device;
use App\Traits\Charts\GetItemChartsTrait;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class DeviceTemplateComponent extends Component
{
    use GetItemChartsTrait, NotificationTrait;

    public ?Device $device;

    public string $search = "";

    public $template;

    public bool $hasCharts = false;

    public array $charts = [];

    public bool $chartModal = false;

    public array $logs = [];

    public $updatedInterface = [];

    public $updatedInterfaceKey = '';

    public $interfaceType = '';

    public bool $updateDrawer = false;

    public bool $logModal = false;

    public function mount($template)
    {
        $this->template = $template;

        if (Chart::itemCharts('device:' . $this->device->id)->first()) {
            $this->hasCharts = true;
        }
    }

    public function openUpdateDrawer($key, $interfaceType)
    {
        $this->updatedInterface = $this->template[$interfaceType][$key];
        $this->updatedInterfaceKey = $key;
        $this->interfaceType = $interfaceType;

        return $this->updateDrawer = true;
    }

    public function update()
    {
        (new DeviceTemplateEngine())->update(
            device: $this->device,
            updatedInterface: $this->updatedInterface,
            updatedInterfaceType: $this->interfaceType,
            updatedInterfaceKey: $this->updatedInterfaceKey
        );

        $this->redirect('/devices/' . $this->device->id, true);

        return $this->success_alert('Upraveno');
    }

    public function closeDrawer()
    {
        $this->updatedInterface = [];
        $this->updatedInterfaceKey = '';
        $this->interfaceType = '';

        return $this->updateDrawer = false;
    }

    public function loadLog($oid)
    {
        $this->logs = (new DeviceSnmpEngine($this->device))->get_bulk($oid);

        return $this->logModal = true;
    }

    public function restartInterface($oid)
    {
        return ((new DeviceSnmpEngine($this->device))->set($oid, '') == true)
            ? $this->success_alert('Interface restartován')
            : $this->error_alert('Nepodařilo se restartovat');
    }

    public function closeDialog()
    {
        $this->logs = [];
        $this->charts = [];
        $this->chartModal = false;

        return $this->logModal = false;
    }

    public function delete()
    {
        $this->device->update([
            'template' => null,
        ]);

        $this->redirect('/devices/' . $this->device->id, true);

        return $this->success_alert('Šablona odebrána');
    }

    public function loadCharts()
    {
        $this->charts = $this->get_charts(
            item: 'device:' . $this->device->id,
            useDisctinct: true
        );

        return $this->chartModal = true;
    }

    public function render()
    {
        return view('livewire.iptv.devices.device-template-component');
    }
}
