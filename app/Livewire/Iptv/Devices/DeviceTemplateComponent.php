<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Chart;
use App\Models\Device;
use Livewire\Component;
use App\Models\DeviceTemplateGpu;
use App\Traits\Charts\GetItemChartsTrait;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Engines\Devices\SNMP\DeviceSnmpEngine;
use App\Engines\Devices\Templates\DeviceTemplateEngine;
use App\Traits\Devices\GetDeviceGpuModuleTemplateTrait;

class DeviceTemplateComponent extends Component
{
    use GetItemChartsTrait, NotificationTrait, GetDeviceGpuModuleTemplateTrait;

    public ?Device $device;

    public string $search = '';

    public mixed $template;

    public array $charts = [];

    public bool $updateDrawer = false;
    public bool $logModal = false;
    public bool $chartModal = false;
    public bool $hasCharts = false;

    public array $logs = [];
    public array $updatedInterface = [];
    public string $updatedInterfaceKey = '';
    public string $interfaceType = '';

    public array $gpuModules = [];
    public ?string $gpuModel = "";

    public function mount(mixed $template): void
    {
        $this->template = $template;

        if (Chart::itemCharts('device:' . $this->device->id)->first()) {
            $this->hasCharts = true;
        }
    }

    public function openUpdateDrawer(string $key, string $interfaceType): void
    {
        $this->updatedInterface = $this->template[$interfaceType][$key];
        $this->updatedInterfaceKey = $key;
        $this->interfaceType = $interfaceType;
        $this->gpuModules = DeviceTemplateGpu::get()->toArray();
        $this->updateDrawer = true;
    }

    public function update(): mixed
    {
        if (!blank($this->gpuModel)) {
            $this->updatedInterface['Model'] = $this->gpuModel;
        }
        (new DeviceTemplateEngine())->update(
            device: $this->device,
            updatedInterface: $this->updatedInterface,
            updatedInterfaceType: $this->interfaceType,
            updatedInterfaceKey: $this->updatedInterfaceKey
        );

        $this->redirect('/devices/' . $this->device->id, true);

        return $this->success_alert('Upraveno');
    }

    public function closeDrawer(): void
    {
        $this->updatedInterface = [];
        $this->updatedInterfaceKey = '';
        $this->interfaceType = '';

        $this->updateDrawer = false;
        $this->reset('gpuModel');
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

        $this->redirect('/devices/' . $this->device->id, true);

        return $this->success_alert('Šablona odebrána');
    }

    public function loadCharts(): void
    {
        $this->charts = $this->get_charts(
            item: 'device:' . $this->device->id,
            useDisctinct: true
        );

        $this->chartModal = true;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.device-template-component');
    }
}
