<?php

namespace App\Observers;

use App\Events\BroadcastLogEvent;
use App\Jobs\LogJob;
use App\Models\Loger;
use App\Models\SatelitCard;
use Illuminate\Support\Facades\Auth;

class SatelitCardObserver
{
    public function created(SatelitCard $satelitCard)
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::CREATED_TYPE,
            item: "satelit_card:$satelitCard->id",
            payload: json_encode([
                'id' => $satelitCard->id,
                'name' => $satelitCard->name,
            ])
        );
        BroadcastLogEvent::dispatch('satelit_card', $satelitCard->id);
    }

    public function updated(SatelitCard $satelitCard)
    {
        if (Auth::user()) {
            LogJob::dispatch(
                user: Auth::user()->email,
                type: Loger::UPDATED_TYPE,
                item: "satelit_card:$satelitCard->id",
                payload: json_encode([
                    'id' => $satelitCard->id,
                    'name' => $satelitCard->name,
                ])
            );
        }
        BroadcastLogEvent::dispatch('satelit_card', $satelitCard->id);
    }

    public function deleted(SatelitCard $satelitCard)
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::DELETED_TYPE,
            item: "satelit_card:$satelitCard->id",
            payload: json_encode([
                'id' => $satelitCard->id,
                'name' => $satelitCard->name,
            ])
        );
        BroadcastLogEvent::dispatch('satelit_card', $satelitCard->id);
    }
}
