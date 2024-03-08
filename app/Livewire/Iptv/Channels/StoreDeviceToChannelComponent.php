<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Device;
use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Traits\Livewire\NotificationTrait;

class StoreDeviceToChannelComponent extends Component
{
    use NotificationTrait;

    public bool $storeModal = false;

    public ?Channel $channel;

    public $channelType;

    public $devices;

    #[Validate('required', message: "Vyberte zařízení")]
    #[Validate('exists:devices,id', message: "Zařízení neexistuje v DB")]
    public $deviceId;

    #[Validate('required', message: "Hodnota musí být vyplněna true / false")]
    #[Validate('boolean', message: "Neplatný formát")]
    public bool $is_backup = false;

    public $device = null;

    public function mount()
    {
        $this->devices = Device::get(['id', 'name']);
    }

    public function store()
    {
        $this->validate();

        if ($this->is_backup == true) {
            $channelToDevice = $this->channelType . ":" . $this->channel->id . ":backup";
        } else {
            $channelToDevice = $this->channelType . ":" . $this->channel->id;
        }

        $device = Device::find($this->deviceId);
        $channels = $device->has_channels;
        if (is_null($channels)) {
            $channels = [];
            array_push($channels, $channelToDevice);
            $device->update([
                'has_channels' => $channels
            ]);
        } else {
            array_push($channels, $channelToDevice);
            $device->update([
                'has_channels' => $channels
            ]);
        }

        if ($this->channelType == 'multicast') {
            $this->dispatch('update_multicasts.' . $this->channel->id);
        }

        $this->redirect('/channels/' . $this->channel->id . "/" . $this->channelType);

        return $this->success_alert("Upraveno");
    }

    public function openModal()
    {
        $this->storeModal = true;
    }

    public function closeDialog()
    {
        $this->storeModal = false;
        $this->deviceId = null;
    }

    public function render()
    {
        return view('livewire.iptv.channels.store-device-to-channel-component');
    }
}
