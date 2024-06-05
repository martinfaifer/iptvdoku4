<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Cache;
use App\Traits\Livewire\NotificationTrait;

class DeviceComponent extends Component
{
    use NotificationTrait;

    public ?Device $device;

    public ?array $nmsCahedData = null;

    public ?array $nimbleCachedData = null;

    public ?array $grapeTranscoderData = null;

    public function mount()
    {
        //
    }

    #[On('refresh_device.{device.id}')]
    public function render()
    {
        if (isset($this->device)) {
            $this->nmsCahedData = Cache::get('nms_'.$this->device->id);
            $this->nimbleCachedData = Cache::get('nimble_'.$this->device->id.'_incoming_streams');
            $this->grapeTranscoderData = Cache::get(('grape_transcoder_'.$this->device->id));

            return view('livewire.iptv.devices.device-component')->title($this->device?->name);
        }

        return view('livewire.iptv.devices.device-component');
    }
}
