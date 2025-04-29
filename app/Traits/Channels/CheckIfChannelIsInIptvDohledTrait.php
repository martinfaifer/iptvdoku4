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
        if (!Cache::has('in_iptv_dohled_' . $ip)) {
            if (IptvDohledUrl::where('stream_url', $ip)->first()) {
                $isIn = true;
            } else {
                $isIn = false;
            }

            Cache::put('in_iptv_dohled_' . $ip, $isIn, 60);
        }

        // $isIn = Cache::get($ip);
        return Cache::get('in_iptv_dohled_' . $ip);
    }

    public function can_notify(string $ip): bool
    {
        $isIn = false;

        if (!Cache::has('can_notify_from_dohled_' . $ip)) {
            if (IptvDohledUrl::where('stream_url', $ip)->first()) {
                $isIn = true;
            }
            Cache::put('can_notify_from_dohled_' . $ip, $isIn, 60);
        }

        return Cache::get('can_notify_from_dohled_' . $ip);
    }
}
