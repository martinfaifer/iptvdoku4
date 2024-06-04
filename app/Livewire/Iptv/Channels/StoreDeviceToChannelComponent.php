<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Device;
use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\StoreDeviceToChannelForm;

class StoreDeviceToChannelComponent extends Component
{
    use NotificationTrait;

    public StoreDeviceToChannelForm $form;

    public bool $storeModal = false;

    public ?Channel $channel;

    public $channelType;

    public $devices;

    public $device = null;

    public function mount()
    {
        $this->devices = Device::get(['id', 'name']);
    }

    public function create()
    {
        $this->form->create();
        $this->storeModal = false;
        // $this->redirect(url()->previous(), true);
        $this->dispatch('refresh_channel_has_devices_' . $this->channelType . '_' . $this->channel->id);
        return $this->success_alert('Upraveno');
    }

    public function openModal()
    {
        $this->resetErrorBag();
        $this->form->setChannel($this->channel, $this->channelType);
        return $this->storeModal = true;
    }

    public function closeDialog()
    {
        $this->form->reset();
        return $this->storeModal = false;
        // $this->deviceId = null;
    }

    public function render()
    {
        return view('livewire.iptv.channels.store-device-to-channel-component');
    }
}
