<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\TagOnItem;
use Illuminate\Console\Command;
use App\Mail\SendEventWasEndedMail;
use Illuminate\Support\Facades\Mail;
use App\Traits\Channels\CacheChannelsForApi;

class EndCalendarEventCommand extends Command
{
    use CacheChannelsForApi;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:end-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'End calendar event if has action';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (Event::where('end_date', now()->format('Y-m-d'))
            ->where('end_time', now()->format('H:i'))
            ->first()
        ) {
            foreach (Event::where('end_date', now()->format('Y-m-d'))
                ->where('end_time', now()->format('H:i'))
                ->get() as $event) {

                if (! is_null($event->tag_id) && ! empty($event->channels)) {

                    foreach (json_decode($event->channels) as $channelId) {
                        TagOnItem::where('item_id', $channelId)
                            ->where('type', 'channel')
                            ->where('tag_id', $event->tag_id)->delete();
                    }

                    $this->cache_channels_with_detail();
                }

                Mail::to($event->creator)->queue(new SendEventWasEndedMail($event));
            }
        }
    }
}
