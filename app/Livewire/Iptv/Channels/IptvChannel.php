<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Cache;
use App\Traits\Livewire\NotificationTrait;

class IptvChannel extends Component
{
    use NotificationTrait;

    public ?Channel $channel;

    public string|int $availableTimeShiftTime = 0;

    public function mount(Channel $channel)
    {
        if (!Cache::has('channel_with_multicast_' . $channel->id)) {
            Cache::forever(
                'channel_with_multicast_' . $channel->id,
                $channel->load(['multicasts', 'multicasts.channel_source'])
            );
        }
        $this->channel = Cache::get('channel_with_multicast_' . $channel->id);
    }

    public function getTimeShiftTime()
    {
        $cachedNanguApiResult = Cache::get('nangu_channel_' . $this->channel->id . '_timeshift');

        if (!is_null($cachedNanguApiResult)) {
            return $this->availableTimeShiftTime = $cachedNanguApiResult['timeshift'] / 1440;
        }

        return $this->availableTimeShiftTime;
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
