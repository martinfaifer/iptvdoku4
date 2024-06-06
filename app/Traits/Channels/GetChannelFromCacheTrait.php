<?php
namespace App\Traits\Channels;

use App\Models\Channel;
use Illuminate\Support\Facades\Cache;

trait GetChannelFromCacheTrait
{
    public function get_channels_from_cache()
    {
        if(!Cache::has('channels_menu')) {
            Cache::forever('channels_menu', Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']));
        }
        return Cache::get('channels_menu');
    }
}
