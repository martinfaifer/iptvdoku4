<?php

namespace App\Livewire\Iptv\Channels\Device;

use App\Models\Channel;
use Livewire\Component;
use Illuminate\Support\Collection;
use App\Traits\Devices\DeviceHasChannelsTrait;


class DeviceHasChannelAndConnectionMapComponent extends Component
{
    use DeviceHasChannelsTrait;

    public ?Collection $devices;
    public Collection $schemaDevices;

    public ?Channel $channel;

    public $channelType;

    public bool $isBackup = false;

    public bool $isHiddenChannelConnectionMap = false;

    public bool $isHiddenBackupChannelConnectionMap = true;

    public function mount($devices)
    {
        $this->devices = $devices;

        $this->schemaDevices = $this->devices_belongs_to_channel_type(
            channelWithType: 'multicast:' . $this->channel->id
        );

        $this->schemaDevices = $this->devices->merge($this->schemaDevices);
    }

    public function showOrHideDeviceConnectionMap()
    {
        return $this->isHiddenChannelConnectionMap = !$this->isHiddenChannelConnectionMap;
    }

    public function showOrHideBackupDeviceConnectionMap()
    {
        return $this->isHiddenBackupChannelConnectionMap = !$this->isHiddenBackupChannelConnectionMap;
    }

    public function render()
    {
        return view('livewire.iptv.channels.device.device-has-channel-and-connection-map-component');
    }
}
