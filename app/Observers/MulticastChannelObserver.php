<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Models\Loger;
use App\Models\ChannelMulticast;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendEmailNotificationJob;
use App\Jobs\DeleteStreamFromIptvDohledJob;

class MulticastChannelObserver
{
    public function created(ChannelMulticast $multicast)
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
                "Byl přidán multicast k " . $multicast->channel->name,
                "Uživatel " . Auth::user()->email . " přidal multicast k " . $multicast->channel->name,
                Auth::user()->email,
                'notify_if_channel_change'
            );
        }
    }

    public function updated(ChannelMulticast $multicast)
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
            "Byl upraven multicast u  " . $multicast->channel->name,
            "Uživatel " . Auth::user()->email . " upravil multicast u " . $multicast->channel->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }

    public function deleted(ChannelMulticast $multicast)
    {
        DeleteStreamFromIptvDohledJob::dispatch($multicast->stb_ip);
        DeleteStreamFromIptvDohledJob::dispatch($multicast->source_ip);

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
            "Byl odebrán multicast u " . $multicast->channel->name,
            "Uživatel " . Auth::user()->email . " odebral multicast u " . $multicast->channel->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }
}
