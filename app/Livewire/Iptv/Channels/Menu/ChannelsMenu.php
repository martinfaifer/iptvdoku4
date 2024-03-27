<?php

namespace App\Livewire\Iptv\Channels\Menu;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

class ChannelsMenu extends Component
{

    public Collection $channels;

    public function mount()
    {
        $this->channels = Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']);
    }

    #[On('update_channels_sidebar')]
    public function refreshChannelsSidebar()
    {
        return $this->channels = Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']);
    }

    public function render()
    {
        return view('livewire.iptv.channels.menu.channels-menu');
    }
}
