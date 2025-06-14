<?php

namespace App\Traits\Devices;

use App\Models\Device;
use Illuminate\Support\Facades\Cache;

trait DeviceHasChannelsTrait
{
    public function devices_belongs_to_channel_type(string $channelWithType): mixed
    {

        return Device::with('category')->get()->filter(function ($device) use ($channelWithType) {
            if (is_array($device->has_channels)) {
                return in_array($channelWithType, $device->has_channels);
            }
        });
    }
}
