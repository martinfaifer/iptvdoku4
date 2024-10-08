<?php

namespace App\Livewire\Iptv\Channels\H265;

use App\Models\Channel;
use Livewire\Component;
use App\Models\ChannelQuality;
use Livewire\Attributes\Locked;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\StoreH265ChannelForm;

class StoreH265Channel extends Component
{
    use NotificationTrait;

    public StoreH265ChannelForm $form;

    #[Locked]
    public ?Channel $channel;

    public mixed $availableFormats;

    public bool $storeModal = false;

    public function boot(): void
    {
        $this->availableFormats = ChannelQuality::availableFormatsFor('h265')->get();
    }

    public function openModal(): void
    {
        $this->form->setChannel($this->channel);
        $this->storeModal = true;
    }

    public function store(): mixed
    {
        $storeResponse = $this->form->store();
        $this->closeDialog();
        if ($storeResponse == true) {
            $this->redirect(url()->previous(), true);
            return $this->success_alert('Přidáno');
        }

        return $this->error_alert('Nebylo nic vyplněno');
    }

    public function closeDialog(): void
    {
        $this->storeModal = false;
        // $this->form->closeForm();
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.channels.h265.store-h265-channel');
    }
}
