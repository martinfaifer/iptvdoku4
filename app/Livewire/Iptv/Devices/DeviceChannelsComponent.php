<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use App\Traits\Channels\GetChannelBelongsToDeviceTrait;
use Livewire\Attributes\On;
use Livewire\Component;

class DeviceChannelsComponent extends Component
{
    use GetChannelBelongsToDeviceTrait;

    public string $search = '';

    public ?Device $device;

    public function mount(Device $device): void
    {
        $this->device = $device;
    }

    public function get_channel(string $channelWithType): ?array
    {
        $explodedChannelWithType = explode(':', $channelWithType);

        return $this->channel(
            channelType: $explodedChannelWithType[0],
            channel_id: (int) $explodedChannelWithType[1],
            isBackup: isset($explodedChannelWithType[3]) ? true : false,
        );
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col gap-4 w-52">
                <div class="skeleton h-32 w-full"></div>
                <div class="skeleton h-4 w-28"></div>
                <div class="skeleton h-4 w-full"></div>
                <div class="skeleton h-4 w-full"></div>
            </div>
        </div>
        HTML;
    }

    #[On('deviceHasChannel.{device.id}')]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.device-channels-component', [
            'channels' => $this->device->has_channels,
        ]);
    }
}
