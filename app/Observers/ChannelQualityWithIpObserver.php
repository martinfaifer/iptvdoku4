<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Models\H264;
use App\Models\H265;
use App\Models\Loger;
use App\Models\ChannelQualityWithIp;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendEmailNotificationJob;
use App\Jobs\DeleteStreamFromIptvDohledJob;

class ChannelQualityWithIpObserver
{
    public function cerated(ChannelQualityWithIp $channelQualityWithIp)
    {
        if (! is_null($channelQualityWithIp->h264_id)) {
            $item = 'h264:'.H264::find($channelQualityWithIp->h264_id)->channel_id;
            $channel = H264::find($channelQualityWithIp->h264_id)->channel->name;
        }

        if (! is_null($channelQualityWithIp->h265_id)) {
            $item = 'h265:'.H265::find($channelQualityWithIp->h265_id)->channel_id;
            $channel = H265::find($channelQualityWithIp->h265_id)->channel->name;
        }

        if (Auth::user()) {
            LogJob::dispatch(
                user: Auth::user()->email,
                type: Loger::CREATED_TYPE,
                item: $item,
                payload: json_encode([
                    'id' => $channelQualityWithIp->id,
                    'channel_quality_id' => $channelQualityWithIp->channel_quality_id,
                    'ip' => $channelQualityWithIp->ip,
                ])
            );

            SendEmailNotificationJob::dispatch(
                "Byl přidán nový unicastový výstup u " . $channel,
                "Uživatel " . Auth::user()->email . " přidal nový unicastový výstup u  " . $channel,
                Auth::user()->email,
                'notify_if_channel_change'
            );
        }
    }

    public function updated(ChannelQualityWithIp $channelQualityWithIp)
    {
        if (! is_null($channelQualityWithIp->h264_id)) {
            $item = 'h264:'.H264::find($channelQualityWithIp->h264_id)->channel_id;
            $channel = H264::find($channelQualityWithIp->h264_id)->channel->name;
        }

        if (! is_null($channelQualityWithIp->h265_id)) {
            $item = 'h265:'.H265::find($channelQualityWithIp->h265_id)->channel_id;
            $channel = H265::find($channelQualityWithIp->h265_id)->channel->name;
        }

        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::UPDATED_TYPE,
            item: $item,
            payload: json_encode([
                'id' => $channelQualityWithIp->id,
                'channel_quality_id' => $channelQualityWithIp->channel_quality_id,
                'ip' => $channelQualityWithIp->ip,
            ])
        );
        SendEmailNotificationJob::dispatch(
            "Byl upraven unicastový výstup u " . $channel,
            "Uživatel " . Auth::user()->email . " upravil unicastový výstup u  " . $channel,
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }

    public function deleted(ChannelQualityWithIp $channelQualityWithIp)
    {
        if (! is_null($channelQualityWithIp->h264_id)) {
            $item = 'h264:'.H264::find($channelQualityWithIp->h264_id)->channel_id;
            $channel = H264::find($channelQualityWithIp->h264_id)->channel->name;
        }

        if (! is_null($channelQualityWithIp->h265_id)) {
            $item = 'h265:'.H264::find($channelQualityWithIp->h265_id)->channel_id;
            $channel = H265::find($channelQualityWithIp->h265_id)->channel->name;
        }

        DeleteStreamFromIptvDohledJob::dispatch($channelQualityWithIp->ip);

        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::DELETED_TYPE,
            item: $item,
            payload: json_encode([
                'id' => $channelQualityWithIp->id,
                'channel_quality_id' => $channelQualityWithIp->channel_quality_id,
                'ip' => $channelQualityWithIp->ip,
            ])
        );

        SendEmailNotificationJob::dispatch(
            "Byl odebrán unicastový výstup u " . $channel,
            "Uživatel " . Auth::user()->email . " odebral unicastový výstup u  " . $channel,
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }
}
