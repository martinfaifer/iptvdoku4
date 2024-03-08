<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class DeviceComponent extends Component
{
    use NotificationTrait;

    public ?Device $device;

    public ?array $nmsCahedData = null;

    public ?array $nimbleCachedData = null;

    public function mount()
    {
        //
    }

    public function render()
    {
        if (isset($this->device)) {
            $this->nmsCahedData = Cache::get('nms_'.$this->device->id);
            $this->nimbleCachedData = Cache::get('nimble_'.$this->device->id.'_incoming_streams');
        }

        return view('livewire.iptv.devices.device-component');
    }
}
