<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Cache;
use App\Traits\Livewire\NotificationTrait;
use App\Actions\Channels\CompletlyDeleteChannelAction;

class IptvChannel extends Component
{
    use NotificationTrait;

    public mixed $channel = null;

    public string|int $availableTimeShiftTime = 0;

    public function mount(mixed $channel = null): void
    {
        if (!blank($channel)) {
            if (!$channelModel = Channel::where('id', $channel)->first()) {
                $this->redirect('/', true);
            } else {
                $this->channel = $channelModel;
            }
        } else {
            $this->channel = $channel;
        }
    }

    public function getTimeShiftTime(): void
    {
        $cachedNanguApiResult = Cache::get('nangu_channel_' . $this->channel->id . '_timeshift');

        if (! is_null($cachedNanguApiResult)) {
            $this->availableTimeShiftTime = $cachedNanguApiResult['timeshift'] / 1440;
        }
    }

    #[On('update_iptv_channel')]
    public function refresh_channel(): void
    {
        $this->channel = Channel::find($this->channel->id)->load(['multicasts', 'multicasts.channel_source']);
    }

    #[On('update_iptv_channel')]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        if (! blank($this->channel)) {
            if (! Cache::has('channel_with_multicast_' . $this->channel->id)) {
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
