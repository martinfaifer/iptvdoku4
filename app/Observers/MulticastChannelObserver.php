<?php

namespace App\Observers;

use App\Jobs\DeleteStreamFromIptvDohledJob;
use App\Jobs\LogJob;
use App\Jobs\SendEmailNotificationJob;
use App\Models\Channel;
use App\Models\ChannelMulticast;
use App\Models\Loger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MulticastChannelObserver
{
    public function created(ChannelMulticast $multicast): void
    {
        if (Auth::user()) {
            LogJob::dispatch(
                user: Auth::user()->email,
                type: Loger::CREATED_TYPE,
                item: "multicast:$multicast->channel_id",
                payload: json_encode([
                    'id' => $multicast->id,
                    'channel_id' => $multicast->channel_id,
                    'stb_ip' => $multicast->stb_ip,
                    'source_ip' => $multicast->source_ip,
                    'channel_source_id' => $multicast->channel_source_id,
                    'is_backup' => $multicast->is_backup,
                    'devices_id' => $multicast->devices_id,
                    'status' => $multicast->status,
                ])
            );

            SendEmailNotificationJob::dispatch(
                'Byl přidán multicast k ' . $multicast->channel->name,
                'Uživatel ' . Auth::user()->email . ' přidal multicast k ' . $multicast->channel->name,
                Auth::user()->email,
                'notify_if_channel_change'
            );
        }

        Cache::forever('channel_with_multicast_' . $multicast->channel_id, Channel::find($multicast->channel_id)->load(['multicasts', 'multicasts.channel_source']));
    }

    public function updated(ChannelMulticast $multicast): void
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::UPDATED_TYPE,
            item: "multicast:$multicast->channel_id",
            payload: json_encode([
                'id' => $multicast->id,
                'channel_id' => $multicast->channel_id,
                'stb_ip' => $multicast->stb_ip,
                'source_ip' => $multicast->source_ip,
                'channel_source_id' => $multicast->channel_source_id,
                'is_backup' => $multicast->is_backup,
                'devices_id' => $multicast->devices_id,
                'status' => $multicast->status,
            ])
        );

        SendEmailNotificationJob::dispatch(
            'Byl upraven multicast u  ' . $multicast->channel->name,
            'Uživatel ' . Auth::user()->email . ' upravil multicast u ' . $multicast->channel->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );

        if (Cache::has('channel_with_multicast_' . $multicast->channel_id)) {
            Cache::forget('channel_with_multicast_' . $multicast->channel_id);
        }
        Cache::forever(
            'channel_with_multicast_' . $multicast->channel_id,
            Channel::find($multicast->channel_id)
                ->load(['multicasts', 'multicasts.channel_source'])
        );
    }

    public function deleted(ChannelMulticast $multicast): void
    {
        if (! is_null($multicast->stb_ip)) {
            DeleteStreamFromIptvDohledJob::dispatch($multicast->stb_ip);
        }
        if (! is_null($multicast->source_ip)) {
            DeleteStreamFromIptvDohledJob::dispatch($multicast->source_ip);
        }

        if (Cache::has('channel_with_multicast_' . $multicast->channel_id)) {
            Cache::forget('channel_with_multicast_' . $multicast->channel_id);
        }

        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::DELETED_TYPE,
            item: "multicast:$multicast->channel_id",
            payload: json_encode([
                'id' => $multicast->id,
                'channel_id' => $multicast->channel_id,
                'stb_ip' => $multicast->stb_ip,
            ])
        );

        SendEmailNotificationJob::dispatch(
            'Byl odebrán multicast u ' . $multicast->channel->name,
            'Uživatel ' . Auth::user()->email . ' odebral multicast u ' . $multicast->channel->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }
}
