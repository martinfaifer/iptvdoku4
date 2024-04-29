<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Attributes\On;
use Livewire\Component;

class IptvChannel extends Component
{
    use NotificationTrait;

    public ?Channel $channel;

    public function mount(Channel $channel)
    {
        $this->channel = $channel->load(['multicasts', 'multicasts.channel_source']);
    }

    // #[On('update_iptv_channel.{channel.id}')]
    public function refresh_channel()
    {
        return $this->channel = Channel::find($this->channel->id)->load(['multicasts', 'multicasts.channel_source']);
    }

    public function render()
    {
        return view('livewire.iptv.channels.iptv-channel')->title($this->channel?->name);
    }
}
