<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use App\Services\Api\NanguTv\ChannelsService;

class ChannelDetail extends Component
{
    public Channel $channel;

    public function render()
    {
        return view('livewire.iptv.channels.channel-detail', [
            'channel' => $this->channel->load('channelCategory'),
            'nanguChannelDetail' => (new ChannelsService())->detail($this->channel->nangu_channel_code)
        ]);
    }
}
