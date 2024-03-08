<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Models\ChannelMulticast;
use App\Models\Loger;
use Illuminate\Support\Facades\Auth;

class MulticastChannelObserver
{
    public function created(ChannelMulticast $multicast)
    {
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
    }

    public function deleted(ChannelMulticast $multicast)
    {
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
    }
}
