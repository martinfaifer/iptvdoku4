<?php

namespace App\Traits\Channels;

use App\Models\ChannelRegion;
use Illuminate\Support\Facades\Cache;

trait ChannelRegionTrait
{
    public function getCachedChannelRegions(): mixed
    {
        if (!Cache::has('channel_regions')) {
            Cache::forever('channel_regions',  ChannelRegion::get());
        }

        return Cache::get('channel_regions');
    }

    public function removeCachedChannelRegions(): void
    {
        Cache::delete('channel_regions');
    }
}
