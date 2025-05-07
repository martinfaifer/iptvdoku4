<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SetelitHasDevicesComponent extends Component
{
    public Collection $hasDevices;

    public function mount(Device $device): void
    {
        $this->hasDevices = Device::inTemplate('"Satelit":'.$device->id)->get(['id', 'name']);
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.setelit-has-devices-component', [
            'headers' => [
                ['key' => 'name', 'label' => 'zařízení', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
