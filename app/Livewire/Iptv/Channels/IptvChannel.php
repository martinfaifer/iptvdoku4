<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class IptvChannel extends Component
{
    use NotificationTrait;

    public ?Channel $channel;

    public string|int $availableTimeShiftTime = 0;

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function getTimeShiftTime()
    {
        $cachedNanguApiResult = Cache::get('nangu_channel_' . $this->channel->id . '_timeshift');

        if (!is_null($cachedNanguApiResult)) {
            return $this->availableTimeShiftTime = $cachedNanguApiResult['timeshift'] / 1440;
        }

        return $this->availableTimeShiftTime;
    }

    // #[On('update_iptv_channel')]
    public function refresh_channel()
    {
        // dd(Channel::find($this->channel->id)->load(['multicasts', 'multicasts.channel_source']));
        return $this->channel = Channel::find($this->channel->id)->load(['multicasts', 'multicasts.channel_source']);
    }

    // #[On('update_iptv_channel')]
    public function render()
    {
        if (!blank($this->channel)) {
            if (!Cache::has('channel_with_multicast_' . $this->channel->id)) {
                Cache::forever(
                    'channel_with_multicast_' . $this->channel->id,
                    $this->channel->load(['multicasts', 'multicasts.channel_source'])
                );
            }
            $this->channel = Cache::get('channel_with_multicast_' . $this->channel->id);
        }

        return view('livewire.iptv.channels.iptv-channel')->title($this->channel?->name);
    }
}
