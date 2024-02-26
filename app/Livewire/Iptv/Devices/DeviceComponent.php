<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use App\Traits\Livewire\NotificationTrait;

class DeviceComponent extends Component
{
    use NotificationTrait;

    public ?Device $device;

    public null|array $nmsCahedData = null;

    public function mount()
    {
        //
    }

    public function render()
    {
        if (isset($this->device)) {
            $this->nmsCahedData = Cache::get('nms_' . $this->device->id);
        }
        return view('livewire.iptv.devices.device-component');
    }
}
