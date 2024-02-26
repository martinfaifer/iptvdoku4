<?php

namespace App\Livewire\Iptv\Devices;

use App\Engines\Devices\SNMP\DeviceSnmpEngine;
use App\Models\Device;
use Livewire\Component;
use App\Engines\Devices\Templates\DeviceTemplateEngine;
use App\Traits\Livewire\NotificationTrait;

class DeviceTemplateComponent extends Component
{
    use NotificationTrait;

    public ?Device $device;

    public $template;

    public array $logs = [];

    public $updatedInterface = [];

    public $updatedInterfaceKey = "";

    public $interfaceType = "";

    public bool $updateDrawer = false;

    public bool $logModal = false;

    public function mount($template)
    {
        $this->template = $template;
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

        $this->success('Upraveno');
        $this->redirect('/devices/' . $this->device->id, true);
    }

    public function closeDrawer()
    {
        $this->updatedInterface = [];
        $this->updatedInterfaceKey = "";
        $this->interfaceType = "";
        $this->updateDrawer = false;
    }


    public function loadLog($oid)
    {
        $this->logs = (new DeviceSnmpEngine($this->device))->get_bulk($oid);

        $this->logModal = true;
    }

    public function restartInterface($oid)
    {
        return ((new DeviceSnmpEngine($this->device))->set($oid, "") == true)
            ? $this->success_alert("Interface restartován")
            : $this->error_alert('Nepodařilo se restartovat');
    }

    public function closeDialog()
    {
        $this->logs = [];
        return $this->logModal = false;
    }

    public function render()
    {
        return view('livewire.iptv.devices.device-template-component');
    }
}
