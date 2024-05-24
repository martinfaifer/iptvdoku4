<?php

namespace App\Http\Resources;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Traits\Channels\CacheChannelsForApi;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\Channels\CheckIfChannelInInPromoTrait;
use App\Traits\Channels\GetGeniusTvChannelPaclagesTrait;

class ApiChannelsResource extends JsonResource
{
    use CheckIfChannelInInPromoTrait, GetGeniusTvChannelPaclagesTrait, CacheChannelsForApi;

    /**
     * Transform the resource into an array.
     *
     * This method is responsible for converting the Channel resource into an array that can be returned as a response.
     * It first checks if the 'channels_in_api' cache exists. If it doesn't, it calls the 'cache_channels_with_detail' method to populate the cache.
     * Then, it retrieves the 'api/v1/public/channels' cache and returns it.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (!Cache::has('channels_in_api')) {
            $this->cache_channels_with_detail();
        }

        return Cache::get('channels_in_api');
    }

    protected function get_value_from_array(?array $array, string $key)
    {
        if (is_null($array)) {
            return null;
        }

        return $array[$key];
    }
}
