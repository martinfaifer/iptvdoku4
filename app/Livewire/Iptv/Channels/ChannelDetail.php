<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use App\Services\Api\Epg\EpgConnectService;
use App\Services\Api\NanguTv\ChannelsService;
use App\Traits\Channels\GetGeniusTvChannelPaclagesTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ChannelDetail extends Component
{
    use GetGeniusTvChannelPaclagesTrait;

    #[Locked]
    public Channel $channel;

    public bool $channelDetailDrawer = false;

    public function openChannelDetailDrawer(): void
    {
        $this->channelDetailDrawer = true;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.channels.channel-detail', [
            'channel' => $this->channel->load('channelCategory'),
            'channelRegion' => $this->channel->load('region'),
            'channelProgrammer' => $this->channel->load('channelProgramer', 'channelProgramer.contacts'),
            'nanguChannelDetail' => (Cache::has('nangu_channel_' . $this->channel->id)) ? Cache::get('nangu_channel_' . $this->channel->id) : (new ChannelsService())->detail($this->channel->nangu_channel_code),
            'channelPackages' => $this->get_packages(json_decode($this->channel->geniustv_channel_packages_id)),
            'epg' => (new EpgConnectService())->get_epg_name_by_id($this->channel->epg_id),
        ]);
    }
}
