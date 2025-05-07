<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use App\Traits\Devices\GrapeTranscoders\GrapeTranscoderChannelTrait;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class GrapeTranscodersApiComponent extends Component
{
    use GrapeTranscoderChannelTrait, NotificationTrait;

    public ?Device $device;

    public ?array $grapeTranscoderData = null;

    public array $channelsOnDevice = [];

    public function mount(Device $device): void
    {
        $this->device = $device;
        $this->grapeTranscoderData = Cache::get(('grape_transcoder_'.$this->device->id));
        $this->load_channels_from_api();
    }

    #[On('reload_streams_on_transcoder.{device.id}')]
    public function load_channels_from_api(): void
    {
        $this->channelsOnDevice = $this->streams_on_transcoder(device: $this->device);
    }

    public function pause(string $pid): mixed
    {
        $response = $this->pause_transcoding(
            pid: $pid,
            device: $this->device
        );

        $this->dispatch('reload_streams_on_transcoder.'.$this->device->id);
        if (array_key_exists('alert', $response)) {
            if ($response['alert']['status'] == 'success') {
                return $this->success_alert($response['alert']['msg']);
            }
        }

        return $this->error_alert('Stream se nepodařilo zastavit');
    }

    public function play(string|int $streamId): mixed
    {
        $response = $this->start_transcoding(
            streamId: $streamId,
            device: $this->device
        );

        $this->dispatch('reload_streams_on_transcoder.'.$this->device->id);
        if (array_key_exists('alert', $response)) {
            if ($response['alert']['status'] == 'success') {
                return $this->success_alert($response['alert']['msg']);
            }
        }

        return $this->error_alert('Stream se nepodařilo spustit');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.grape-transcoders-api-component', [
            'headers' => [
                ['key' => 'nazev', 'label' => 'Stream', 'class' => 'dark:text-white/80'],
                ['key' => 'src', 'label' => 'Zdroj', 'class' => 'dark:text-white/80'],
                ['key' => 'dst', 'label' => 'Dst1', 'class' => 'dark:text-white/80'],
                ['key' => 'dst2', 'label' => 'Dst2', 'class' => 'dark:text-white/80'],
                ['key' => 'dst3', 'label' => 'Dst3', 'class' => 'dark:text-white/80'],
                ['key' => 'dst4', 'label' => 'Dst4', 'class' => 'dark:text-white/80'],
                ['key' => 'status', 'label' => 'Status', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
