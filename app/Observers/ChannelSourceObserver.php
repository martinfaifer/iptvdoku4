<?php

namespace App\Observers;

use App\Models\ChannelSource;
use Illuminate\Support\Facades\Cache;

class ChannelSourceObserver
{
    public function created(ChannelSource $channelSource): void
    {
        $this->deleted($channelSource);
        Cache::forever('channel_sources', ChannelSource::get());
    }

    public function updated(ChannelSource $channelSource): void
    {
        $this->deleted($channelSource);
        Cache::forever('channel_sources', ChannelSource::get());
    }

    public function deleted(ChannelSource $channelSource): void
    {
        Cache::delete('channel_sources');
        Cache::forever('channel_sources', ChannelSource::get());
    }
}
