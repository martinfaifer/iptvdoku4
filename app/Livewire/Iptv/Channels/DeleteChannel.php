<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Actions\Channels\CompletlyDeleteChannelAction;

class DeleteChannel extends Component
{
    use NotificationTrait;

    public ?Channel $channel;

    public function destroy(Channel $channel): mixed
    {
        if ((new CompletlyDeleteChannelAction($channel))() == true) {
            $this->success_alert('Odebráno');
        } else {
            $this->error_alert('Nepodařilo se odebrat');
        }
        // $channel->delete();

        return $this->redirect('/channels', true);
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.channels.delete-channel');
    }
}
