<?php

namespace App\Livewire\Iptv\Channels\H265;

use App\Models\Channel;
use Livewire\Component;
use App\Models\ChannelQuality;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\StoreH265ChannelForm;

class StoreH265Channel extends Component
{
    use NotificationTrait;

    public StoreH265ChannelForm $form;

    public ?Channel $channel;

    public $availableFormats;

    public bool $storeModal = false;

    public function boot()
    {
        $this->availableFormats = ChannelQuality::availableFormatsFor('h265')->get();
    }

    public function openModal()
    {
        $this->form->setChannel($this->channel);
        $this->storeModal = true;
    }

    public function store()
    {
        $storeResponse = $this->form->store();
        $this->closeDialog();
        $this->dispatch('update_h265.' . $this->channel->id);
        if ($storeResponse == true) {
            return $this->success_alert("Přidáno");
        }
        return $this->error_alert("Nebylo nic vyplněno");
    }

    public function closeDialog()
    {
        $this->storeModal = false;
        // $this->form->closeForm();
    }

    public function render()
    {
        return view('livewire.iptv.channels.h265.store-h265-channel');
    }
}
