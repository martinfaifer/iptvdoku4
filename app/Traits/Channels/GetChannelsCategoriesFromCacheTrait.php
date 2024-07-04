<?php

namespace App\Traits\Channels;

use App\Models\ChannelCategory;
use Illuminate\Support\Facades\Cache;

trait GetChannelsCategoriesFromCacheTrait
{
    public function get_channels_categories_from_cache()
    {
        if (!Cache::has('channels_categories')) {
            Cache::forever('channels_categories', ChannelCategory::orderBy('name')->get(['id', 'name']));
        }
        return Cache::get('channels_categories');
    }
}
