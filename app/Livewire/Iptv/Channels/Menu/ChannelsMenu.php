<?php

namespace App\Livewire\Iptv\Channels\Menu;

use App\Models\Channel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ChannelsMenu extends Component
{
    public Collection $channels;

    public function mount(): void
    {
        if (! Cache::has('channels_menu')) {
            Cache::put('channels_menu', Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']));
        }
        $this->channels = Cache::get('channels_menu');
    }

    public function refreshChannelsSidebar(): void
    {
        $this->channels = Cache::get('channels_menu');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $this->channels = Cache::get('channels_menu');

        return view('livewire.iptv.channels.menu.channels-menu');
    }
}
