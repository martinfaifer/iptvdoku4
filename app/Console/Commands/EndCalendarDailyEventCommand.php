<?php

namespace App\Console\Commands;

use App\Mail\SendEventWasEndedMail;
use App\Models\Event;
use App\Models\TagOnItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EndCalendarDailyEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:end-daily-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'End calendar daily event if has action';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (Event::where('end_date', now()->format('Y-m-d'))
            ->where('end_time', null)
            ->first()
        ) {
            foreach (Event::where('end_date', now()->format('Y-m-d'))
                ->where('end_time', null)
                ->get() as $event) {

                if (! is_null($event->tag_id) && ! empty($event->channels)) {

                    foreach (json_decode($event->channels) as $channelId) {
                        TagOnItem::where('item_id', $channelId)
                            ->where('type', 'channel')
                            ->where('tag_id', $event->tag_id)->delete();
                    }
                }

                Mail::to($event->creator)->queue(new SendEventWasEndedMail($event));
            }
        }
    }
}
