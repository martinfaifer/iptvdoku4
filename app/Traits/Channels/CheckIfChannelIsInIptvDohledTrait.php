<?php

namespace App\Traits\Channels;

use Illuminate\Support\Facades\Cache;

trait CheckIfChannelIsInIptvDohledTrait
{
    public function isInIptvDohledDohled($ip): bool
    {
        $isIn = Cache::get($ip);

        return !$isIn ? false : true;
    }
}
