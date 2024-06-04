<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Device;
use App\Models\Channel;
use Livewire\Attributes\Validate;

class StoreDeviceToChannelForm extends Form
{
    public ?Channel $channel;

    public $channelType;

    #[Validate('required', message: 'Vyberte zařízení')]
    #[Validate('exists:devices,id', message: 'Zařízení neexistuje v DB')]
    public $deviceId = null;

    #[Validate('required', message: 'Hodnota musí být vyplněna true / false')]
    #[Validate('boolean', message: 'Neplatný formát')]
    public bool $is_backup = false;


    public function setChannel(Channel $channel, string $channelType)
    {
        $this->channel = $channel;
        $this->channelType = $channelType;
    }

    public function create()
    {
        $this->validate();

        if ($this->is_backup == true) {
            $channelToDevice = $this->channelType . ':' . $this->channel->id . ':backup';
        } else {
            $channelToDevice = $this->channelType . ':' . $this->channel->id;
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
