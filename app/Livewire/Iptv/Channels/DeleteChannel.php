<?php

namespace App\Livewire\Iptv\Channels;

use App\Actions\Channels\CompletlyDeleteChannelAction;
use App\Models\Channel;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class DeleteChannel extends Component
{
    use NotificationTrait;

    public ?Channel $channel;

    public function destroy(Channel $channel)
    {
        if ((new CompletlyDeleteChannelAction($channel))() == true) {
            $this->success_alert('Odebráno');
        } else {
            $this->error_alert('Nepodařilo se odebrat');
        }
        // $channel->delete();

        return $this->redirect('/channels', true);
    }

    public function render()
    {
        return view('livewire.iptv.channels.delete-channel');
    }
}
