<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class IptvChannel extends Component
{
    use NotificationTrait;

    public ?Channel $channel;

    public function render()
    {
        return view('livewire.iptv.channels.iptv-channel');
    }
}
