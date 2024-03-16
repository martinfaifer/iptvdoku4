<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\TagOnItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEventWasStartedMail;

class StartCalendarDailyEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:start-daily-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start calendar daily event if has action';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (Event
            ::where('start_date', now()->format("Y-m-d"))
            ->where('start_time', null)
            ->first()
        ) {
            foreach (Event
                ::where('start_date', now()->format("Y-m-d"))
                ->where('start_time', null)
                ->get() as $event) {

                if (!is_null($event->tag_id) && !empty($event->channels)) {

                    foreach (json_decode($event->channels) as $channelId) {
                        TagOnItem::create([
                            'item_id' => $channelId,
                            'type' => "channel",
                            'tag_id' => $event->tag_id,
                        ]);
                    }
                }
                Mail::to($event->creator)->queue(new SendEventWasStartedMail($event));
            }
        }
    }
}
