<?php

namespace App\Traits\Channels;

use App\Models\Channel;
use App\Models\ChannelRegion;
use Illuminate\Support\Facades\Cache;

trait CacheChannelsForApi
{
    use CheckIfChannelInInPromoTrait, GetGeniusTvChannelPaclagesTrait;

    public function cache_channels_with_detail(): void
    {
        Cache::pull('channels_in_api');

        $result = [];
        foreach (Channel::orderBy('name', 'asc')->with('channelCategory')->get() as $channel) {
            $result[] = [
                'id' => $channel->id,
                'nazev' => $channel->name,
                'logo' => is_null($channel->logo) ? null : config('app.url') . '/' . str_replace('public', 'storage', $channel->logo),
                'is_radio' => $channel->is_radio,
                'is_multiscreen' => $channel->is_multiscreen,
                'kvalita' => $channel->quality,
                'channelPackages' => implode(',', $this->get_packages(json_decode($channel->geniustv_channel_packages_id))),
                'mainPackages' => implode(',', $this->get_main_packages(json_decode($channel->geniustv_channel_packages_id))),
                'optionalPackages' => implode(',', $this->get_optional_packages(json_decode($channel->geniustv_channel_packages_id))),
                'kategorie' => $channel->channelCategory?->name,
                'popis' => $channel->description,
                'app_order' => $this->get_value_from_array(Cache::get('nangu_channel_' . $channel->id . '_app_order'), 'order'),
                'timeshift' => $this->get_value_from_array(Cache::get('nangu_channel_' . $channel->id . '_timeshift'), 'timeshift'),
                'is_promo' => $this->check_if_is_in_promo($channel),
            ];
        }

        Cache::forever('channels_in_api', $result);
    }

    protected function get_value_from_array(?array $array, string $key): mixed
    {
        if (is_null($array)) {
            return null;
        }

        return $array[$key];
    }

    public function cache_channels_with_region_with_detail(string $region): void
    {
        Cache::pull('channels_in_api_' . $region);
        $result = [];
        if (!Channel::where('channel_region_id', ChannelRegion::where('name', $region)->first()->id)->first()) {
            Cache::forever('channels_in_api_' . $region, $result);
        } else {
            foreach (Channel::where('channel_region_id', ChannelRegion::where('name', $region)->first()->id)->orderBy('name', 'asc')->with('channelCategory')->get() as $channel) {
                $result[] = [
                    'id' => $channel->id,
                    'nazev' => $channel->name,
                    'logo' => is_null($channel->logo) ? null : config('app.url') . '/' . str_replace('public', 'storage', $channel->logo),
                    'is_radio' => $channel->is_radio,
                    'is_multiscreen' => $channel->is_multiscreen,
                    'kvalita' => $channel->quality,
                    'channelPackages' => implode(',', $this->get_packages(json_decode($channel->geniustv_channel_packages_id))),
                    'mainPackages' => implode(',', $this->get_main_packages(json_decode($channel->geniustv_channel_packages_id))),
                    'optionalPackages' => implode(',', $this->get_optional_packages(json_decode($channel->geniustv_channel_packages_id))),
                    'kategorie' => $channel->channelCategory?->name,
                    'popis' => $channel->description,
                    'app_order' => $this->get_value_from_array(Cache::get('nangu_channel_' . $channel->id . '_app_order'), 'order'),
                    'timeshift' => $this->get_value_from_array(Cache::get('nangu_channel_' . $channel->id . '_timeshift'), 'timeshift'),
                    'is_promo' => $this->check_if_is_in_promo($channel),
                ];
            }

            Cache::forever('channels_in_api_' . $region, $result);
        }
    }
}
