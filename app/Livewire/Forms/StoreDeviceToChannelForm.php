<?php

namespace App\Livewire\Forms;

use App\Models\Channel;
use App\Models\Device;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StoreDeviceToChannelForm extends Form
{
    public ?Channel $channel;

    public string|null $channelType = null;

    #[Validate('required', message: 'Vyberte zařízení')]
    #[Validate('exists:devices,id', message: 'Zařízení neexistuje v DB')]
    public int|null $deviceId = null;

    #[Validate('required', message: 'Hodnota musí být vyplněna true / false')]
    #[Validate('boolean', message: 'Neplatný formát')]
    public bool $is_backup = false;

    public function setChannel(Channel $channel, string $channelType): void
    {
        $this->channel = $channel;
        $this->channelType = $channelType;
    }

    public function create(): void
    {
        $this->validate();

        if ($this->is_backup == true) {
            $channelToDevice = $this->channelType.':'.$this->channel->id.':backup';
        } else {
            $channelToDevice = $this->channelType.':'.$this->channel->id;
        }

        $device = Device::find($this->deviceId);
        $channels = $device->has_channels;
        if (is_null($channels)) {
            $channels = [];
            array_push($channels, $channelToDevice);
            $device->update([
                'has_channels' => $channels,
            ]);
        } else {
            array_push($channels, $channelToDevice);
            $device->update([
                'has_channels' => $channels,
            ]);
        }
        $this->reset();
    }
}
