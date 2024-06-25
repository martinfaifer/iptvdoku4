<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use App\Services\Api\Nimble\ConnectService;
use App\Traits\Livewire\NotificationTrait;

class NimbleApiComponent extends Component
{
    use NotificationTrait;

    public ?Device $device;

    public $deviceNimbleCachedData;

    public array $nimbleServerApiData;

    public array $incomingStreams;

    public array $outcomingStreams;

    public array $sourceStream;

    public bool $detailModal = false;

    public bool $editServerApiModal = false;

    public function mount()
    {
        $this->incomingStreams = Cache::get('nimble_' . $this->device->id . '_incoming_streams');
        // dd($this->incomingStreams);
        $this->outcomingStreams = Cache::get('nimble_' . $this->device->id . '_outgoing_streams');
        // dd($this->outcomingStreams, $this->incomingStreams);
        $this->deviceNimbleCachedData = Cache::get('nimble_' . $this->device->id);
    }

    public function openEditServerApiModal()
    {
        // $this->nimbleServerApiData =  (new ConnectService())->connect(
        //     endpoint: "get_server",
        //     serverId: $this->deviceNimbleCachedData['nimble_id'],
        // );

        // dd($this->nimbleServerApiData);
        return $this->editServerApiModal = true;
    }

    // public function updateNimbleServerName()
    // {
    //     dd($this->nimbleServerApiData['server']['name']);
    // }

    public function openSourceDetailStream($source)
    {
        $this->sourceStream = $source;

        return $this->detailModal = true;
    }

    public function closeModal()
    {
        $this->editServerApiModal = false;
        return $this->detailModal = false;
    }


    public function startIncomingStream($streamId)
    {
        (new ConnectService())->connect(
            endpoint: "incoming_streams_resume",
            serverId: $this->deviceNimbleCachedData['nimble_id'],
            streamId: $streamId
        );

        return $this->success_alert("Akce odeslána na server");
    }

    public function stopIncomingStream($streamId)
    {
        (new ConnectService())->connect(
            endpoint: "incoming_streams_pause",
            serverId: $this->deviceNimbleCachedData['nimble_id'],
            streamId: $streamId
        );

        return $this->success_alert("Akce odeslána na server");
    }

    public function restartStream($streamId)
    {
        (new ConnectService())->connect(
            endpoint: "incoming_streams_restart",
            serverId: $this->deviceNimbleCachedData['nimble_id'],
            streamId: $streamId
        );

        return $this->success_alert("Akce odeslána na server");
    }

    public function render()
    {
        return view('livewire.iptv.devices.nimble-api-component');
    }
}
