<?php

namespace App\Traits\Channels;

use Illuminate\Support\Facades\Cache;

trait GetChannelDataOnIptvDohledTrait
{
    public function channel_on_dohled($ip): null|array
    {
        return Cache::get($ip);
    }
}
