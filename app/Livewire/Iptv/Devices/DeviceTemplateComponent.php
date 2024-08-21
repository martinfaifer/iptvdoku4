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

    public string $search = '';

    public mixed $template;

    public bool $hasCharts = false;

    public array $charts = [];

    public bool $chartModal = false;

    public array $logs = [];

    public array $updatedInterface = [];

    public string $updatedInterfaceKey = '';

    public string $interfaceType = '';

    public bool $updateDrawer = false;

    public bool $logModal = false;

    public function mount(mixed $template): void
    {
        $this->template = $template;

        if (Chart::itemCharts('device:'.$this->device->id)->first()) {
            $this->hasCharts = true;
        }
    }

    public function openUpdateDrawer(string $key, string $interfaceType): void
    {
        $this->updatedInterface = $this->template[$interfaceType][$key];
        $this->updatedInterfaceKey = $key;
        $this->interfaceType = $interfaceType;

        $this->updateDrawer = true;
    }

    public function update(): mixed
    {
        (new DeviceTemplateEngine())->update(
            device: $this->device,
            updatedInterface: $this->updatedInterface,
            updatedInterfaceType: $this->interfaceType,
            updatedInterfaceKey: $this->updatedInterfaceKey
        );

        $this->redirect('/devices/'.$this->device->id, true);

        return $this->success_alert('Upraveno');
    }

    public function closeDrawer(): void
    {
        $this->updatedInterface = [];
        $this->updatedInterfaceKey = '';
        $this->interfaceType = '';

        $this->updateDrawer = false;
    }

    public function loadLog(string $oid): void
    {
        $this->logs = (new DeviceSnmpEngine($this->device))->get_bulk($oid);

        $this->logModal = true;
    }

    public function restartInterface(string $oid): mixed
    {
        return ((new DeviceSnmpEngine($this->device))->set($oid, '') == true)
            ? $this->success_alert('Interface restartován')
            : $this->error_alert('Nepodařilo se restartovat');
    }

    public function closeDialog(): void
    {
        $this->logs = [];
        $this->charts = [];
        $this->chartModal = false;

        $this->logModal = false;
    }

    public function delete(): mixed
    {
        $this->device->update([
            'template' => null,
        ]);

        $this->redirect('/devices/'.$this->device->id, true);

        return $this->success_alert('Šablona odebrána');
    }

    public function loadCharts(): void
    {
        $this->charts = $this->get_charts(
            item: 'device:'.$this->device->id,
            useDisctinct: true
        );

        $this->chartModal = true;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.device-template-component');
    }
}
