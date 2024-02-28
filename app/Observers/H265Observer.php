<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Models\H265;
use App\Models\Loger;
use Illuminate\Support\Facades\Auth;

class H265Observer
{
    public function created(H265 $h265)
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::CREATED_TYPE,
            item: "h265:$h265->channel_id",
            payload: json_encode([
                'id' => $h265->id,
                'devices_id' => $h265->device_id,
                'status' => $h265->status
            ])
        );
    }

    public function updated(H265 $h265)
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::UPDATED_AT,
            item: "h265:$h265->channel_id",
            payload: json_encode([
                'id' => $h265->id,
                'devices_id' => $h265->device_id,
                'status' => $h265->status
            ])
        );
    }

    public function deleted(H265 $h265)
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::DELETED_TYPE,
            item: "h265:$h265->channel_id",
            payload: json_encode([
                'id' => $h265->id,
                'devices_id' => $h265->device_id,
                'status' => $h265->status
            ])
        );
    }
}
