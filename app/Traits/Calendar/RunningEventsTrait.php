<?php

namespace App\Traits\Calendar;

use App\Models\Event;

trait RunningEventsTrait
{
    public function running_events(): array
    {
        return Event::runningEvents()
            ->orderBy('start_date', 'ASC')
            ->with(['user', 'sftp_server'])
            ->get()
            ->toArray();
    }

    public function running_events_with_frontendNotification()
    {
        return Event::runningEvents()
            ->hasFeNotification()
            ->orderBy('start_date', 'ASC')
            ->with(['user'])
            ->get()
            ->toArray();
    }
}
