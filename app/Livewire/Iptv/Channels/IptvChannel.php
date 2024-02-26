<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use App\Models\ChannelType;
use Livewire\Attributes\On;
use App\Models\ChannelCategory;
use Livewire\Attributes\Reactive;
use App\Livewire\Forms\UpdateIptvChannel;
use App\Traits\Livewire\NotificationTrait;

class IptvChannel extends Component
{
    use NotificationTrait;

    public ?Channel $channel;

    public function render()
    {
        return view('livewire.iptv.channels.iptv-channel');
    }
}
