<?php

namespace App\Traits\Channels;

use App\Models\ChannelProgramer;
use Illuminate\Support\Facades\Cache;

trait ChannelProgramerTrait
{
    public function getCachedChannelProgramers(): mixed
    {
        if (!Cache::has('channel_programers')) {
            Cache::forever('channel_programers', ChannelProgramer::get());
        }

        return Cache::get('channel_programers');
    }

    public function removeCachedChannelProgramers(): void
    {
        Cache::delete('channel_programers');
    }
}
