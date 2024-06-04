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
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function openModal()
    {
        $this->form->setChannel($this->channel, $this->channelType);
        $this->storeModal = true;
    }

    public function closeDialog()
    {
        $this->form->reset();
        $this->storeModal = false;
        // $this->deviceId = null;
    }

    public function render()
    {
        return view('livewire.iptv.channels.store-device-to-channel-component');
    }
}
