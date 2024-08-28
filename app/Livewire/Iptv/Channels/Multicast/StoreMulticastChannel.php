<?php

namespace App\Livewire\Iptv\Channels\Multicast;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChannelSource;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\StoreMulticastChannelForm;
use Livewire\Attributes\Locked;

class StoreMulticastChannel extends Component
{
    use NotificationTrait;

    public StoreMulticastChannelForm $form;
    #[Locked]
    public ?Channel $channel;

    public bool $storeModal = false;

    public mixed $channelSources;

    public function mount(): void
    {
        $this->channelSources = ChannelSource::get();
    }

    public function openModal(): void
    {
        $this->form->setChannel($this->channel);
        $this->storeModal = true;
    }

    public function store(): mixed
    {
        $this->form->store();
        $this->closeDialog();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Přidáno');
    }

    public function closeDialog(): void
    {
        $this->storeModal = false;
        $this->form->closeForm();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.channels.multicast.store-multicast-channel');
    }
}
