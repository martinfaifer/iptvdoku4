<?php

namespace App\Livewire\Iptv\Channels;

use App\Livewire\Forms\StoreDeviceToChannelForm;
use App\Models\Channel;
use App\Models\Device;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class StoreDeviceToChannelComponent extends Component
{
    use NotificationTrait;

    public StoreDeviceToChannelForm $form;

    public bool $storeModal = false;

    public ?Channel $channel;

    public string $channelType;

    public mixed $devices;

    public mixed $device = null;

    public function mount(): void
    {
        $this->devices = Device::get(['id', 'name']);
    }

    public function create(): mixed
    {
        $this->form->create();
        $this->storeModal = false;
        // $this->redirect(url()->previous(), true);
        $this->dispatch('refresh_channel_has_devices_' . $this->channelType . '_' . $this->channel->id);

        return $this->success_alert('Upraveno');
    }

    public function openModal(): void
    {
        $this->resetErrorBag();
        $this->form->setChannel($this->channel, $this->channelType);

        $this->storeModal = true;
    }

    public function closeDialog(): void
    {
        $this->form->reset();

        $this->storeModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.channels.store-device-to-channel-component');
    }
}
