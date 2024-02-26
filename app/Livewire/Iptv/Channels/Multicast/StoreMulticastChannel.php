<?php

namespace App\Livewire\Iptv\Channels\Multicast;

use App\Models\Channel;
use Livewire\Component;
use App\Models\ChannelSource;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\StoreMulticastChannelForm;

class StoreMulticastChannel extends Component
{
    use NotificationTrait;

    public StoreMulticastChannelForm $form;

    public ?Channel $channel;

    public bool $storeModal = false;

    public $channelSources;

    public function mount()
    {
        $this->channelSources = ChannelSource::get();
    }

    public function openModal()
    {
        $this->form->setChannel($this->channel);
        $this->storeModal = true;
    }

    public function store()
    {
        $this->form->store();
        $this->closeDialog();
        $this->dispatch('update_multicasts.'.$this->channel->id);
        return $this->success_alert("Přidáno");
    }

    public function closeDialog()
    {
        $this->storeModal = false;
        $this->form->closeForm();
    }

    public function render()
    {
        return view('livewire.iptv.channels.multicast.store-multicast-channel');
    }
}
