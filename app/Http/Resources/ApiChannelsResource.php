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
