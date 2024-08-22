<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class DeviceComponent extends Component
{
    use NotificationTrait;

    public mixed $device = null;

    public ?array $nmsCahedData = null;

    public ?array $nimbleCachedData = null;

    public ?array $grapeTranscoderData = null;

    public function mount(mixed $device = null): void
    {
        if (!blank($device)) {
            if (!$deviceModel = Device::where('id', $device)->first()) {
                $this->redirect('/devices', true);
            } else {
                $this->device = $deviceModel;
            }
        } else {
            $this->device = $device;
        }
    }

    #[On('refresh_device')]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        if (isset($this->device)) {
            $this->nmsCahedData = Cache::get('nms_' . $this->device->id);
            $this->nimbleCachedData = Cache::get('nimble_' . $this->device->id . '_incoming_streams');
            $this->grapeTranscoderData = Cache::get(('grape_transcoder_' . $this->device->id));

            return view('livewire.iptv.devices.device-component')->title($this->device?->name);  // @phpstan-ignore-line
        }

        return view('livewire.iptv.devices.device-component');
    }
}
