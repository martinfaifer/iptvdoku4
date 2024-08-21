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

    public function mount(Channel $channel): void
    {
        $this->channel = $channel;
    }

    public function getTimeShiftTime(): void
    {
        $cachedNanguApiResult = Cache::get('nangu_channel_' . $this->channel->id . '_timeshift');

        if (!is_null($cachedNanguApiResult)) {
            $this->availableTimeShiftTime = $cachedNanguApiResult['timeshift'] / 1440;
        }
    }

    // #[On('update_iptv_channel')]
    public function refresh_channel(): void
    {
        // dd(Channel::find($this->channel->id)->load(['multicasts', 'multicasts.channel_source']));
        $this->channel = Channel::find($this->channel->id)->load(['multicasts', 'multicasts.channel_source']);
    }

    // #[On('update_iptv_channel')]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
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
