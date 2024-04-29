<?php

namespace App\Livewire\Iptv\Channels\Menu;

use App\Models\Channel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class ChannelsMenu extends Component
{
    public Collection $channels;

    public function mount()
    {
        if (! Cache::has('channels_menu')) {
            Cache::put('channels_menu', Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']));
        }
        $this->channels = Cache::get('channels_menu');
    }

    #[On('update_channels_sidebar')]
    public function refreshChannelsSidebar()
    {
        return $this->channels = Cache::get('channels_menu');
    }

    public function render()
    {
        return view('livewire.iptv.channels.menu.channels-menu');
    }
}
