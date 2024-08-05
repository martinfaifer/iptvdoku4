<?php

namespace App\Traits\Channels;

use App\Models\IptvDohledUrl;
use Illuminate\Support\Facades\Cache;

trait CheckIfChannelIsInIptvDohledTrait
{
    public function isInIptvDohledDohled($ip): bool
    {
        $isIn = IptvDohledUrl::where('stream_url', $ip)->first();

        // $isIn = Cache::get($ip);
        return !$isIn ? false : true;
    }

    public function can_notify($ip): bool
    {
        $isIn = IptvDohledUrl::where('stream_url', $ip)->first();

        if (!$isIn) {
            return false;
        }

        return $isIn->can_notify;
    }
}
