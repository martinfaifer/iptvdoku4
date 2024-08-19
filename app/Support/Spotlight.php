<?php

namespace App\Support;

use App\Models\Channel;
use App\Models\ChannelMulticast;
use App\Models\ChannelQualityWithIp;
use App\Models\Device;
use App\Models\Ip;
use App\Models\SatelitCard;
use App\Models\SftpServer;
use App\Models\WikiTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Spotlight
{
    public function search(Request $request)
    {
        if (! Auth::user()) {
            return [];
        }

        return collect()
            ->merge($this->devices($request->search))
            ->merge($this->channels($request->search))
            ->merge($this->multicasts($request->search))
            ->merge($this->unicasts($request->search))
            ->merge($this->satelitCards($request->search))
            ->merge($this->ftpServers($request->search))
            ->merge($this->wiki($request->search))
            ->merge($this->ip($request->search));
    }

    public function devices(string $search)
    {
        return Device::search($search)->get()->map(function (Device $device) {
            return [
                'id' => 'device_'.$device->id,
                'name' => $device->name,
                'description' => 'Zařízení',
                // 'icon' => Blade::render("<x-si-satellite class='h-6 w-6 text-sky-500' />"),
                'link' => "/devices/{$device->id}",
            ];
        });
    }

    public function channels(string $search)
    {
        return Channel::fulltextSearch($search)->get()->map(function (Channel $channel) {
            return [
                'id' => 'channel_'.$channel->id,
                'name' => $channel->name,
                'description' => 'Kanál',
                // 'icon' => Blade::render("<x-si-satellite class='h-6 w-6 text-sky-500' />"),
                'link' => "/channels/{$channel->id}/multicast",
            ];
        });
    }

    public function multicasts(string $search)
    {
        return ChannelMulticast::search($search)->with('channel')->get()->map(function (ChannelMulticast $channelMulticast) {
            return [
                'id' => 'multicast_'.$channelMulticast->id,
                'name' => $channelMulticast->channel->name,
                'description' => 'Multicast',
                // 'icon' => Blade::render("<x-si-satellite class='h-6 w-6 text-sky-500' />"),
                'link' => "/channels/{$channelMulticast->channel_id}/multicast",
            ];
        });
    }

    public function unicasts(string $search)
    {
        return ChannelQualityWithIp::search($search)->with('h264.channel', 'h265.channel')->get()->map(function (ChannelQualityWithIp $unicastChannel) {
            if (! is_null($unicastChannel->h264)) {
                $channelName = $unicastChannel->h264->channel->name;
                $channelId = $unicastChannel->h264->channel_id;
                $type = 'h264';
            }
            if (! is_null($unicastChannel->h265)) {
                $channelName = $unicastChannel->h265->channel->name;
                $channelId = $unicastChannel->h265->channel_id;
                $type = 'h265';
            }

            if (isset($channelName) && isset($channelId)) {
                return [
                    'id' => 'unicast_'.$unicastChannel->id,
                    'name' => $channelName,
                    'description' => $type,
                    // 'icon' => Blade::render("<x-si-satellite class='h-6 w-6 text-sky-500' />"),
                    'link' => "/channels/{$channelId}/{$type}",
                ];
            }
        });
    }

    public function satelitCards(string $search)
    {
        return SatelitCard::search($search)->get()->map(function (SatelitCard $satCard) {
            return [
                'id' => 'satCard_'.$satCard->id,
                'name' => $satCard->name,
                'description' => 'Satelitní karta',
                // 'icon' => Blade::render("<x-si-satellite class='h-6 w-6 text-sky-500' />"),
                'link' => "/sat-cards/{$satCard->id}",
            ];
        });
    }

    public function ftpServers(string $search)
    {
        return SftpServer::search($search)->get()->map(function (SftpServer $server) {
            return [
                'id' => 'server_'.$server->id,
                'name' => $server->name,
                'description' => 'FTP server',
                // 'icon' => Blade::render("<x-si-satellite class='h-6 w-6 text-sky-500' />"),
                'link' => "/sftps/{$server->id}",
            ];
        });
    }

    public function wiki(string $search)
    {
        return WikiTopic::search($search)->get()->map(function (WikiTopic $topic) {
            return [
                'id' => 'wiki_'.$topic->id,
                'name' => $topic->title,
                'description' => 'WIKI',
                // 'icon' => Blade::render("<x-si-satellite class='h-6 w-6 text-sky-500' />"),
                'link' => "/wiki/{$topic->id}",
            ];
        });
    }

    public function ip(string $search)
    {
        return Ip::search($search)->get()->map(function (Ip $ip) {
            return [
                'id' => 'ip_'.$ip->id,
                'name' => $ip->ip_address.'/'.$ip->cidr,
                'description' => 'IP',
                // 'icon' => Blade::render("<x-si-satellite class='h-6 w-6 text-sky-500' />"),
                'link' => "/prefixes/{$ip->id}",
            ];
        });
    }
}
