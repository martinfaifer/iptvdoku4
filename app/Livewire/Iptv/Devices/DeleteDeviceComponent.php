<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use Livewire\Component;
use App\Traits\Livewire\NotificationTrait;

class DeleteDeviceComponent extends Component
{
    use NotificationTrait;

    public ?Device $device;

    public function destroy(Device $device)
    {
        // delete ssh and delete alerts
        $device->ssh->delete();
        $device->delete();

        return $this->redirect("/devices", true);
    }

    public function render()
    {
        return view('livewire.iptv.devices.delete-device-component');
    }
}
