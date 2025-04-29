<?php
namespace App\Traits\Channels;

use Illuminate\Support\Facades\Cache;
use App\Models\GeniusTvChannelPackage;

trait GeniusTVChannelPackagesTrait
{
    public function getCachedGeniusTvChannelPackages(): mixed
    {
        if(!Cache::has('geniustv_channel_packages')) {
            Cache::forever('geniustv_channel_packages', GeniusTvChannelPackage::get());
        }

        return Cache::get('geniustv_channel_packages');
    }

    public function removeCachedGeniusTvChannelPackages(): void
    {
        Cache::delete('geniustv_channel_packages');
    }
}
