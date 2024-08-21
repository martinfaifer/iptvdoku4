<?php

namespace App\Traits\Channels;

use Illuminate\Support\Facades\Cache;

trait GetChannelDataOnIptvDohledTrait
{
    public function channel_on_dohled(string $ip): ?array
    {
        return Cache::get($ip);
    }
}
