<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Jobs\SendEmailNotificationJob;
use App\Models\H264;
use App\Models\Loger;
use Illuminate\Support\Facades\Auth;

class H264Observer
{
    public function created(H264 $h264)
    {
        if (! Auth::user()) {
            $email = 'system@';

            SendEmailNotificationJob::dispatch(
                'Byl přidán H264 k '.$h264->channel->name,
                'Uživatel '.Auth::user()->email.' přidal H264 k '.$h264->channel->name,
                Auth::user()->email,
                'notify_if_channel_change'
            );
        }
        LogJob::dispatch(
            user: isset($email) ? $email : Auth::user()->email,
            type: Loger::CREATED_TYPE,
            item: "h264:$h264->channel_id",
            payload: json_encode([
                'id' => $h264->id,
                'devices_id' => $h264->device_id,
                'status' => $h264->status,
            ])
        );
    }

    public function updated(H264 $h264)
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::UPDATED_AT,
            item: "h264:$h264->channel_id",
            payload: json_encode([
                'id' => $h264->id,
                'devices_id' => $h264->device_id,
                'status' => $h264->status,
            ])
        );

        SendEmailNotificationJob::dispatch(
            'Byl upravil H264 u '.$h264->channel->name,
            'Uživatel '.Auth::user()->email.' upravil H264 u '.$h264->channel->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }

    public function deleted(H264 $h264)
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::DELETED_TYPE,
            item: "h264:$h264->channel_id",
            payload: json_encode([
                'id' => $h264->id,
                'devices_id' => $h264->device_id,
                'status' => $h264->status,
            ])
        );

        SendEmailNotificationJob::dispatch(
            'Byl odebral H264 u '.$h264->channel->name,
            'Uživatel '.Auth::user()->email.' odebral u '.$h264->channel->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }
}
