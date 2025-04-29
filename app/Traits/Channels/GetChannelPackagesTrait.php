<?php

namespace App\Traits\Channels;

use Illuminate\Support\Facades\Cache;
use App\Models\GeniusTvChannelPackage;

trait GetChannelPackagesTrait
{

    public function getPackages(): mixed
    {
        if (!Cache::has('channel_packages')) {
            Cache::forever('channel_packages', GeniusTvChannelPackage::get());
        }

        return Cache::get('channel_packages');
    }

    public function removeChannelPackagesFromCache(): void
    {
        Cache::delete('channel_packages');
    }
}
