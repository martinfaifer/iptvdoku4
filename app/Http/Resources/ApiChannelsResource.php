<?php

namespace App\Http\Resources;

use App\Models\Channel;
use App\Traits\Channels\CheckIfChannelInInPromoTrait;
use App\Traits\Channels\GetGeniusTvChannelPaclagesTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class ApiChannelsResource extends JsonResource
{
    use CheckIfChannelInInPromoTrait, GetGeniusTvChannelPaclagesTrait;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result = [];
        foreach (Channel::orderBy('name', 'asc')->with('channelCategory')->get() as $channel) {

            $result[] = [
                'id' => $channel->id,
                'nazev' => $channel->name,
                'logo' => is_null($channel->logo) ? null : config('app.url').'/'.str_replace('public', 'storage', $channel->logo),
                'is_radio' => $channel->is_radio,
                'is_multiscreen' => $channel->is_multiscreen,
                'kvalita' => $channel->quality,
                'channelPackages' => implode($this->get_packages(json_decode($channel->geniustv_channel_packages_id))),
                'kategorie' => $channel->channelCategory->name,
                'popis' => $channel->description,
                'app_order' => $this->get_value_from_array(Cache::get('nangu_channel_'.$channel->id.'_app_order'), 'order'),
                'timeshift' => $this->get_value_from_array(Cache::get('nangu_channel_'.$channel->id.'_timeshift'), 'timeshift'),
                'is_promo' => $this->check_if_is_in_promo($channel),
            ];
        }

        return $result;
    }

    protected function get_value_from_array(?array $array, string $key)
    {
        if (is_null($array)) {
            return null;
        }

        return $array[$key];
    }
}
