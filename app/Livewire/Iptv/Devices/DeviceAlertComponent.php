<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Alert;
use App\Models\Device;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class DeviceAlertComponent extends Component
{
    public ?Device $device;

    public Collection $deviceAlerts;

    public function mount(): void
    {
        $this->deviceAlerts = Alert::where('item_id', $this->device->id)->orderBy('id', 'DESC')->take(10)->get();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.device-alert-component');
    }
}
