<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendDeletedEventNotificationMail;

class EventObserver
{
    public function deleted(Event $event)
    {
        // send notification about deleted event if had users
        if (!is_null($event->users)) {
            foreach (json_decode($event->users) as $userId) {
                Mail::to(User::find($userId)->email)->send(new SendDeletedEventNotificationMail($event));
            }
        }
    }
}
