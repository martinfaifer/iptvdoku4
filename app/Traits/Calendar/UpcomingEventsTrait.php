<?php

namespace App\Traits\Calendar;

use App\Models\Event;

trait UpcomingEventsTrait
{
    public function upcoming_events(): array
    {
        return Event::where('start_date', '>=', now()->format('Y-m-d'))
            ->orderBy('start_date', 'ASC')
            ->with(['user', 'sftp_server'])
            ->get()
            ->toArray();
    }
}
