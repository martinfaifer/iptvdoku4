<?php

namespace App\Observers;

use App\Jobs\SendEmailNotificationJob;
use App\Mail\SendDeletedEventNotificationMail;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EventObserver
{
    public function created(Event $event): void
    {
        SendEmailNotificationJob::dispatch(
            'Byla vytvořena nová událost ' . $event->label,
            'Uživatel ' . Auth::user()->email . 'vytvořil událost ' . $event->label,
            Auth::user()->email,
            'notify_if_added_new_event'
        );
    }

    public function deleted(Event $event): void
    {
        // send notification about deleted event if had users
        if (! is_null($event->users)) {
            foreach (json_decode($event->users) as $userId) {
                Mail::to(User::find($userId)->email)->send(new SendDeletedEventNotificationMail($event));
            }
        }
    }
}
