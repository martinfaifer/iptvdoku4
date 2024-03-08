<?php

namespace App\Livewire\Iptv\Channels\Menu;

use App\Models\Channel;
use Livewire\Attributes\On;
use Livewire\Component;

// #[On('update_channels_sidebar')]
class ChannelsMenu extends Component
{
    public function render()
    {
        return view('livewire.iptv.channels.menu.channels-menu', [
            'channels' => Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']),
        ]);
    }
}
