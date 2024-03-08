<?php

namespace App\Livewire\Iptv\Channels\H264;

use App\Livewire\Forms\StoreH264ChannelForm;
use App\Models\Channel;
use App\Models\ChannelQuality;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class StoreH264Channel extends Component
{
    use NotificationTrait;

    public StoreH264ChannelForm $form;

    public ?Channel $channel;

    public $availableFormats;

    public bool $storeModal = false;

    public function boot()
    {
        $this->availableFormats = ChannelQuality::availableFormatsFor('h264')->get();
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
        $this->dispatch('update_h264.'.$this->channel->id);
        if ($storeResponse == true) {
            return $this->success_alert('Přidáno');
        }

        return $this->error_alert('Nebylo nic vyplněno');
    }

    public function closeDialog()
    {
        $this->storeModal = false;
        // $this->form->closeForm();
    }

    public function render()
    {
        return view('livewire.iptv.channels.h264.store-h264-channel');
    }
}
