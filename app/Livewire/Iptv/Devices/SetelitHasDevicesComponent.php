<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class SetelitHasDevicesComponent extends Component
{
    public Collection $hasDevices;

    public function mount(Device $device)
    {
        $this->hasDevices = Device::inTemplate('"Satelit":' . $device->id)->get(['id', 'name']);
    }

    public function render()
    {
        return view('livewire.iptv.devices.setelit-has-devices-component', [
            'headers' => [
                ['key' => 'name', 'label' => 'zařízení', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
