<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use App\Traits\Channels\GetChannelBelongsToDeviceTrait;
use Livewire\Attributes\On;
use Livewire\Component;

class DeviceChannelsComponent extends Component
{
    use GetChannelBelongsToDeviceTrait;

    public ?Device $device;

    public function mount(Device $device)
    {
        $this->device = $device;
    }

    public function get_channel($channelWithType): ?array
    {
        $explodedChannelWithType = explode(':', $channelWithType);

        return $this->channel(
            channelType: $explodedChannelWithType[0],
            channel_id: $explodedChannelWithType[1],
            isBackup: isset($explodedChannelWithType[3]) ? true : false,
        );
    }

    #[On('deviceHasChannel.{device.id}')]
    public function render()
    {
        return view('livewire.iptv.devices.device-channels-component', [
            'channels' => $this->device->has_channels,
        ]);
    }
}
