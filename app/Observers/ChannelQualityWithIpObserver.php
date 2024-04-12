<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Models\ChannelQualityWithIp;
use App\Models\H264;
use App\Models\Loger;
use Illuminate\Support\Facades\Auth;

class ChannelQualityWithIpObserver
{
    public function cerated(ChannelQualityWithIp $channelQualityWithIp)
    {
        if (!is_null($channelQualityWithIp->h264_id)) {
            $item = 'h264:' . H264::find($channelQualityWithIp->h264_id)->channel_id;
        }

        if (!is_null($channelQualityWithIp->h265_id)) {
            $item = 'h265:' . H264::find($channelQualityWithIp->h265_id)->channel_id;
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
        }
    }

    public function updated(ChannelQualityWithIp $channelQualityWithIp)
    {
        if (!is_null($channelQualityWithIp->h264_id)) {
            $item = 'h264:' . H264::find($channelQualityWithIp->h264_id)->channel_id;
        }

        if (!is_null($channelQualityWithIp->h265_id)) {
            $item = 'h265:' . H264::find($channelQualityWithIp->h265_id)->channel_id;
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
    }

    public function deleted(ChannelQualityWithIp $channelQualityWithIp)
    {
        if (!is_null($channelQualityWithIp->h264_id)) {
            $item = 'h264:' . H264::find($channelQualityWithIp->h264_id)->channel_id;
        }

        if (!is_null($channelQualityWithIp->h265_id)) {
            $item = 'h265:' . H264::find($channelQualityWithIp->h265_id)->channel_id;
        }

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
    }
}
