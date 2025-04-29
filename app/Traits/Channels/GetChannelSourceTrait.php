<?php

namespace App\Traits\Channels;

use App\Models\ChannelSource;
use Illuminate\Support\Facades\Cache;

trait GetChannelSourceTrait
{
    public function getCachedChannelSources(): mixed
    {
        if (!Cache::has('channel_sources')) {
            Cache::forever('channel_sources', ChannelSource::get());
        }
        return Cache::get('channel_sources');
    }
}
