<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Models\Loger;
use App\Models\Channel;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Jobs\SendEmailNotificationJob;
use App\Traits\Channels\CacheChannelsForApi;
use App\Jobs\GetChannelDetailFromNanguApiJob;

class ChannelObserver
{
    use CacheChannelsForApi;
    public function created(Channel $channel)
    {
        if (!Auth::user()) {
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
                "Uživatel " . Auth::user()->email . " vytvořil kanál $channel->name",
                Auth::user()->email,
                'notify_if_channel_change'
            );
        }
        Cache::put('channels_menu', Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']));
        $this->cache_channels_with_detail();
    }

    public function updated(Channel $channel)
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

        GetChannelDetailFromNanguApiJob::dispatch($channel, 3600);

        SendEmailNotificationJob::dispatch(
            "Upraven kanál $channel->name",
            "Uživatel " . Auth::user()->email . " upravil kanál $channel->name",
            Auth::user()->email,
            'notify_if_channel_change'
        );

        Cache::put('channels_menu', Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']));
        $this->cache_channels_with_detail();
    }

    public function deleted(Channel $channel)
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::DELETED_TYPE,
            item: "channel:$channel->id",
            payload: json_encode([
                'id' => $channel->id,
                'name' => $channel->name,
            ])
        );
        // delete channel contacts
        Contact::where('type', 'channel')->where('item_id', $channel->id)->delete();
        Cache::put('channels_menu', Channel::orderBy('name')->get(['id', 'name', 'logo', 'is_radio']));
        $this->cache_channels_with_detail();

        SendEmailNotificationJob::dispatch(
            "Odebrán kanál $channel->name",
            "Uživatel " . Auth::user()->email . " odebral kanál $channel->name",
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }
}
