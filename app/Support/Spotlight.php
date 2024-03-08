<?php

namespace App\Support;

use App\Models\Channel;
use App\Models\ChannelMulticast;
use App\Models\Device;
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
            ->merge($this->multicasts($request->search));
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
        return Channel::search($search)->get()->map(function (Channel $channel) {
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
                'description' => 'Kanál',
                // 'icon' => Blade::render("<x-si-satellite class='h-6 w-6 text-sky-500' />"),
                'link' => "/channels/{$channelMulticast->channel_id}/multicast",
            ];
        });
    }
}
