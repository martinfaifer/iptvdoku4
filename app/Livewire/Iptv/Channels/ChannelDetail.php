<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use App\Services\Api\Epg\EpgConnectService;
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
            'nanguChannelDetail' => (Cache::has('nangu_channel_' . $this->channel->id)) ? Cache::get('nangu_channel_' . $this->channel->id) : (new ChannelsService())->detail($this->channel->nangu_channel_code),
            'channelPackages' => $this->get_packages(json_decode($this->channel->geniustv_channel_packages_id)),
            'epg' => (new EpgConnectService())->get_epg_name_by_id($this->channel->epg_id),
        ]);
    }
}
