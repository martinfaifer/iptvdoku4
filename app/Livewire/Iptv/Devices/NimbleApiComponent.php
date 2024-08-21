<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use App\Services\Api\Nimble\ConnectService;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class NimbleApiComponent extends Component
{
    use NotificationTrait;

    public ?Device $device;

    public mixed $deviceNimbleCachedData;

    public array $nimbleServerApiData;

    public array $incomingStreams;

    public array $outcomingStreams;

    public array $sourceStream;

    public bool $detailModal = false;

    public bool $editServerApiModal = false;

    public function mount(): void
    {
        $this->incomingStreams = Cache::get('nimble_'.$this->device->id.'_incoming_streams');
        // dd($this->incomingStreams);
        $this->outcomingStreams = Cache::get('nimble_'.$this->device->id.'_outgoing_streams');
        // dd($this->outcomingStreams, $this->incomingStreams);
        $this->deviceNimbleCachedData = Cache::get('nimble_'.$this->device->id);
    }

    public function openEditServerApiModal(): void
    {
        $this->editServerApiModal = true;
    }

    public function openSourceDetailStream(array $source): void
    {
        $this->sourceStream = $source;

        $this->detailModal = true;
    }

    public function closeModal(): void
    {
        $this->editServerApiModal = false;
        $this->detailModal = false;
    }

    public function startIncomingStream(string|int $streamId): mixed
    {
        (new ConnectService())->connect(
            endpoint: 'incoming_streams_resume',
            serverId: $this->deviceNimbleCachedData['nimble_id'],
            streamId: $streamId
        );

        return $this->success_alert('Akce odeslána na server');
    }

    public function stopIncomingStream(string|int $streamId): mixed
    {
        (new ConnectService())->connect(
            endpoint: 'incoming_streams_pause',
            serverId: $this->deviceNimbleCachedData['nimble_id'],
            streamId: $streamId
        );

        return $this->success_alert('Akce odeslána na server');
    }

    public function restartStream(string|int $streamId): mixed
    {
        (new ConnectService())->connect(
            endpoint: 'incoming_streams_restart',
            serverId: $this->deviceNimbleCachedData['nimble_id'],
            streamId: $streamId
        );

        return $this->success_alert('Akce odeslána na server');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.nimble-api-component');
    }
}
