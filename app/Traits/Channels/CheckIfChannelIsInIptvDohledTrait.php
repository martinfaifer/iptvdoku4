<?php

namespace App\Traits\Channels;

use App\Models\IptvDohledUrl;
use Illuminate\Support\Facades\Cache;

trait CheckIfChannelIsInIptvDohledTrait
{
    public function isInIptvDohledDohled(string|null $ip = null): bool
    {
        if (is_null($ip)) {
            return false;
        }
        $isIn = IptvDohledUrl::where('stream_url', $ip)->first();

        // $isIn = Cache::get($ip);
        return ! $isIn ? false : true;
    }

    public function can_notify(string $ip): bool
    {
        $isIn = IptvDohledUrl::where('stream_url', $ip)->first();

        if (! $isIn) {
            return false;
        }

        return $isIn->can_notify;
    }
}
