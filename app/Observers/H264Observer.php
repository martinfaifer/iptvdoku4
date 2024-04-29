<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Models\H264;
use App\Models\Loger;
use Illuminate\Support\Facades\Auth;

class H264Observer
{
    public function created(H264 $h264)
    {
        if (! Auth::user()) {
            $email = 'system@';
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
    }
}
