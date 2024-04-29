<?php

namespace App\Observers;

use App\Mail\SendDeletedEventNotificationMail;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EventObserver
{
    public function deleted(Event $event)
    {
        // send notification about deleted event if had users
        if (! is_null($event->users)) {
            foreach (json_decode($event->users) as $userId) {
                Mail::to(User::find($userId)->email)->send(new SendDeletedEventNotificationMail($event));
            }
        }
    }
}
