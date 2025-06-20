<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Traits\Livewire\NotificationTrait;

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

    #[Computed(persist: true)]
    public function getTimeShiftTime(): void
    {
        $cachedNanguApiResult = Cache::get('nangu_channel_' . $this->channel->id . '_timeshift');

        if (! is_null($cachedNanguApiResult)) {
            $this->availableTimeShiftTime = $cachedNanguApiResult['timeshift'] / 1440;
        }
    }

    public function downloadLogo(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return Storage::download($this->channel->logo);
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
