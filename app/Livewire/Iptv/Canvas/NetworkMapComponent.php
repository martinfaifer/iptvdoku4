<?php

namespace App\Livewire\Iptv\Canvas;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Channels\GetChannelBelongsToDeviceTrait;

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