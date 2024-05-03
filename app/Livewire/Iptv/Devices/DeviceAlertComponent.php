<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Alert;
use App\Models\Device;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class DeviceAlertComponent extends Component
{

    public ?Device $device;

    public Collection $deviceAlerts;

    public function mount()
    {
        $this->deviceAlerts = Alert::where('item_id', $this->device->id)->orderBy('id', "DESC")->take(10)->get();
    }

    public function render()
    {
        return view('livewire.iptv.devices.device-alert-component');
    }
}
