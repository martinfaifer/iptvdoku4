<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class NimbleApiComponent extends Component
{
    public ?Device $device;

    public array $incomingStreams;

    public array $outcomingStreams;

    public array $sourceStream;

    public bool $detailModal = false;

    public function mount()
    {
        $this->incomingStreams = Cache::get('nimble_'.$this->device->id.'_incoming_streams');
        $this->outcomingStreams = Cache::get('nimble_'.$this->device->id.'_outgoing_streams');
    }

    public function openSourceDetailStream($source)
    {
        $this->sourceStream = $source;

        return $this->detailModal = true;
    }

    public function closeModal()
    {
        return $this->detailModal = false;
    }

    public function render()
    {
        return view('livewire.iptv.devices.nimble-api-component');
    }
}
