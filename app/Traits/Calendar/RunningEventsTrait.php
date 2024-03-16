<?php

namespace App\Traits\Calendar;

use App\Models\Event;

trait RunningEventsTrait
{
    public function running_events(): array
    {
        return Event
            ::where('start_date', "<=", now()->format('Y-m-d'))
            ->where('end_date', ">=", now()->format('Y-m-d'))
            ->orderBy('start_date', "ASC")
            ->with(['user'])
            ->get()
            ->toArray();
    }
}
