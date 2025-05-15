<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\Locked;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Actions\Channels\CompletlyDeleteChannelAction;

class DeleteChannel extends Component
{
    use NotificationTrait;

    #[Locked]
    public ?Channel $channel;

    public function destroy(): mixed
    {
        (new CompletlyDeleteChannelAction($this->channel))();
        $this->redirect('/channels');
        return $this->success_alert('Odebráno');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.channels.delete-channel');
    }
}
