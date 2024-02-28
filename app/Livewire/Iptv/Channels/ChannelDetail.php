<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use App\Services\Api\NanguTv\ChannelsService;
use App\Traits\Channels\GetGeniusTvChannelPaclagesTrait;

class ChannelDetail extends Component
{
    use GetGeniusTvChannelPaclagesTrait;

    public Channel $channel;

    public function render()
    {
        return view('livewire.iptv.channels.channel-detail', [
            'channel' => $this->channel->load('channelCategory'),
            'nanguChannelDetail' => (new ChannelsService())->detail($this->channel->nangu_channel_code),
            'channelPackages' => $this->get_packages(json_decode($this->channel->geniustv_channel_packages_id))
        ]);
    }
}
