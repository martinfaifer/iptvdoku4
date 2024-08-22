<?php

namespace App\Livewire\Iptv\Channels\Device;

use App\Models\Channel;
use App\Traits\Devices\DeviceHasChannelsTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class DeviceHasChannelAndConnectionMapComponent extends Component
{
    use DeviceHasChannelsTrait;

    public ?Collection $devices;

    public Collection $schemaDevices;

    public ?Channel $channel;

    public string $channelType;

    public bool $isBackup = false;

    public bool $isHiddenChannelConnectionMap = true;

    public bool $isHiddenBackupChannelConnectionMap = true;

    public function mount(): void
    {
        // $this->devices = $devices;
        $this->load_devices_data();
    }

    #[On('refresh_channel_has_devices_{channelType}_{channel.id}')]
    public function load_devices_data(): void
    {
        if ($this->isBackup == true) {
            $this->devices = $this->devices_belongs_to_channel_type(
                channelWithType: $this->channelType . ':' . $this->channel->id . ':backup'
            );

            $this->schemaDevices = $this->devices_belongs_to_channel_type(
                channelWithType: 'multicast:' . $this->channel->id . ':backup'
            );
        } else {
            $this->devices = $this->devices_belongs_to_channel_type(
                channelWithType: $this->channelType . ':' . $this->channel->id
            );

            $this->schemaDevices = $this->devices_belongs_to_channel_type(
                channelWithType: 'multicast:' . $this->channel->id
            );
        }

        $this->schemaDevices = $this->devices->merge($this->schemaDevices);
    }

    public function showOrHideDeviceConnectionMap(): void
    {
        $this->isHiddenChannelConnectionMap = ! $this->isHiddenChannelConnectionMap;
    }

    public function showOrHideBackupDeviceConnectionMap(): void
    {
        $this->isHiddenBackupChannelConnectionMap = ! $this->isHiddenBackupChannelConnectionMap;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.channels.device.device-has-channel-and-connection-map-component');
    }
}
