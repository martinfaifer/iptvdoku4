<?php

namespace App\Observers;

use App\Jobs\SendDeletedEventNotificationJob;
use App\Models\Event;

class EventObserver
{
    public function deleted(Event $event)
    {
        // send notification about deleted event if had users
        if (!is_null($event->users)) {
            SendDeletedEventNotificationJob::dispatch(json_decode($event->users), $event);
        }
    }
}
