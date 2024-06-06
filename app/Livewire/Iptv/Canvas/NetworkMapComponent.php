<?php

namespace App\Livewire\Iptv\Canvas;

use App\Traits\Channels\GetChannelBelongsToDeviceTrait;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class NetworkMapComponent extends Component
{
    use GetChannelBelongsToDeviceTrait;

    public Collection $devices;

    public function mount()
    {
        $this->devices = \App\Models\Device::with('category')->get(['id', 'name', 'has_channels', 'device_category_id']);
    }

    public function render()
    {
        return view('livewire.iptv.canvas.network-map-component');
    }
}
