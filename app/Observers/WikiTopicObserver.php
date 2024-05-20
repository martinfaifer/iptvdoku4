<?php

namespace App\Observers;

use App\Models\WikiTopic;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendEmailNotificationJob;

class WikiTopicObserver
{
    /**
     * Handle the WikiTopic "created" event.
     */
    public function created(WikiTopic $wikiTopic): void
    {
        SendEmailNotificationJob::dispatch(
            "Byl přidán nový článek do wiki ",
            "Uživatel " . Auth::user()->email . " vytvořil článek " . $wikiTopic->title,
            Auth::user()->email,
            'notify_if_added_new_wiki_content'
        );
    }

    /**
     * Handle the WikiTopic "updated" event.
     */
    public function updated(WikiTopic $wikiTopic): void
    {
        SendEmailNotificationJob::dispatch(
            "Byl upraven článek na wiki ",
            "Uživatel " . Auth::user()->email . " upravil článek " . $wikiTopic->title,
            Auth::user()->email,
            'notify_if_added_new_wiki_content'
        );
    }

    /**
     * Handle the WikiTopic "deleted" event.
     */
    public function deleted(WikiTopic $wikiTopic): void
    {
        SendEmailNotificationJob::dispatch(
            "Byl odebrán nový článek na wiki ",
            "Uživatel " . Auth::user()->email . " odebral článek " . $wikiTopic->title,
            Auth::user()->email,
            'notify_if_added_new_wiki_content'
        );
    }

    /**
     * Handle the WikiTopic "restored" event.
     */
    public function restored(WikiTopic $wikiTopic): void
    {
        //
    }

    /**
     * Handle the WikiTopic "force deleted" event.
     */
    public function forceDeleted(WikiTopic $wikiTopic): void
    {
        //
    }
}
