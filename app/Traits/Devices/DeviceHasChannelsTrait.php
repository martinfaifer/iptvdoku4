<?php

namespace App\Traits\Devices;

use App\Models\Device;
use Illuminate\Support\Facades\Cache;

trait DeviceHasChannelsTrait
{
    public function devices_belongs_to_channel_type(string $channelWithType): mixed
    {
        if (!Cache::has('devices_belongs_to_channel_type_' . $channelWithType)) {
            Cache::put('devices_belongs_to_channel_type_' . $channelWithType,  Device::with('category')->get()->filter(function ($device) use ($channelWithType) {
                if (is_array($device->has_channels)) {
                    return in_array($channelWithType, $device->has_channels);
                }
            }));
        }

        return Cache::get('devices_belongs_to_channel_type_' . $channelWithType);
    }
}
