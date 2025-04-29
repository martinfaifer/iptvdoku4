<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Models\Note;
use App\Models\Loger;
use App\Models\Channel;
use App\Models\Contact;
use App\Models\ChannelRegion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Jobs\SendEmailNotificationJob;
use App\Traits\Channels\ChannelRegionTrait;
use App\Traits\Channels\CacheChannelsForApi;
use App\Jobs\GetChannelDetailFromNanguApiJob;

class ChannelObserver
{
    use CacheChannelsForApi, ChannelRegionTrait;

    public function created(Channel $channel): void
    {
        if (! Auth::user()) {
            $email = 'system@';
        }

        LogJob::dispatch(
            user: isset($email) ? $email : Auth::user()->email,
            type: Loger::CREATED_TYPE,
            item: "channel:$channel->id",
            payload: json_encode([
                'id' => $channel->id,
                'name' => $channel->name,
                'logo' => $channel->logo,
                'is_radio' => $channel->is_radio,
                'is_multiscreen' => $channel->is_multiscreen,
                'quality' => $channel->quality,
                'category' => $channel->category,
                'description' => $channel->description,
                'nangu_chunk_store_id' => $channel->nangu_chunk_store_id,
                'nangu_channel_code' => $channel->nangu_channel_code,
                'geniustv_channel_packages_id' => $channel->geniustv_channel_packages_id,
            ])
        );

        GetChannelDetailFromNanguApiJob::dispatch($channel, 3600);
        if (Auth::user()) {
            SendEmailNotificationJob::dispatch(
                "Vytvořen nový kanál $channel->name",
                'Uživatel ' . Auth::user()->email . " vytvořil kanál $channel->name",
                Auth::user()->email,
                'notify_if_channel_change'
            );
        }
        Cache::forever('channels_menu', Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']));
        $this->cache_channels_with_detail();
        foreach ($this->getCachedChannelRegions() as $region) {
            $this->cache_channels_with_region_with_detail($region->name);
        }
    }

    public function updated(Channel $channel): void
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::UPDATED_TYPE,
            item: "channel:$channel->id",
            payload: json_encode([
                'id' => $channel->id,
                'name' => $channel->name,
                'logo' => $channel->logo,
                'is_radio' => $channel->is_radio,
                'is_multiscreen' => $channel->is_multiscreen,
                'quality' => $channel->quality,
                'category' => $channel->category,
                'description' => $channel->description,
                'nangu_chunk_store_id' => $channel->nangu_chunk_store_id,
                'nangu_channel_code' => $channel->nangu_channel_code,
                'geniustv_channel_packages_id' => $channel->geniustv_channel_packages_id,
            ])
        );

        if (Cache::has('channel_with_multicast_' . $channel->id)) {
            Cache::forget('channel_with_multicast_' . $channel->id);
        }

        GetChannelDetailFromNanguApiJob::dispatch($channel, 3600);

        SendEmailNotificationJob::dispatch(
            "Upraven kanál $channel->name",
            'Uživatel ' . Auth::user()->email . " upravil kanál $channel->name",
            Auth::user()->email,
            'notify_if_channel_change'
        );

        Cache::forever('channels_menu', Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']));
        $this->cache_channels_with_detail();
        foreach ($this->getCachedChannelRegions() as $region) {
            $this->cache_channels_with_region_with_detail($region->name);
        }
    }

    public function deleted(Channel $channel): void
    {
        try {
            LogJob::dispatch(
                user: Auth::user()->email,
                type: Loger::DELETED_TYPE,
                item: "channel:$channel->id",
                payload: json_encode([
                    'id' => $channel->id,
                    'name' => $channel->name,
                ])
            );
            Cache::forever('channels_menu', Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']));
            $this->cache_channels_with_detail();
            foreach ($this->getCachedChannelRegions() as $region) {
                $this->cache_channels_with_region_with_detail($region->name);
            }

            if (Cache::has('channel_with_multicast_' . $channel->id)) {
                Cache::forget('channel_with_multicast_' . $channel->id);
            }

            SendEmailNotificationJob::dispatch(
                "Odebrán kanál $channel->name",
                'Uživatel ' . Auth::user()->email . " odebral kanál $channel->name",
                Auth::user()->email,
                'notify_if_channel_change'
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
