<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Jobs\SendEmailNotificationJob;
use App\Models\H265;
use App\Models\Loger;
use Illuminate\Support\Facades\Auth;

class H265Observer
{
    public function created(H265 $h265): void
    {
        $email = 'system@';
        if (Auth::user()) {
            $email = Auth::user()->email;
        }
        SendEmailNotificationJob::dispatch(
            'Byl přidán H265 k ' . $h265->channel->name,
            'Uživatel ' . $email . ' přidal H265 k ' . $h265->channel->name,
            $email,
            'notify_if_channel_change'
        );

        LogJob::dispatch(
            user: $email,
            type: Loger::CREATED_TYPE,
            item: "h265:$h265->channel_id",
            payload: json_encode([
                'id' => $h265->id,
                'devices_id' => $h265->devices_id,
                'status' => $h265->status,
            ])
        );
    }

    public function updated(H265 $h265): void
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::UPDATED_AT,
            item: "h265:$h265->channel_id",
            payload: json_encode([
                'id' => $h265->id,
                'devices_id' => $h265->devices_id,
                'status' => $h265->status,
            ])
        );

        SendEmailNotificationJob::dispatch(
            'Byl upraven H265 u ' . $h265->channel->name,
            'Uživatel ' . Auth::user()->email . ' upravil H265 u ' . $h265->channel->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }

    public function deleted(H265 $h265): void
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::DELETED_TYPE,
            item: "h265:$h265->channel_id",
            payload: json_encode([
                'id' => $h265->id,
                'devices_id' => $h265->devices_id,
                'status' => $h265->status,
            ])
        );

        SendEmailNotificationJob::dispatch(
            'Byl odebrán H265 u ' . $h265->channel->name,
            'Uživatel ' . Auth::user()->email . ' odebral H265 u ' . $h265->channel->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }
}
