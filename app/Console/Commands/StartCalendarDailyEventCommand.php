<?php

namespace App\Console\Commands;

use App\Mail\SendEventWasStartedMail;
use App\Models\Event;
use App\Models\TagOnItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Net\SFTP;

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
    public function handle(): mixed
    {
        if (Event::where('start_date', now()->format('Y-m-d'))
            ->where('start_time', null)
            ->first()
        ) {
            foreach (
                Event::where('start_date', now()->format('Y-m-d'))
                    ->where('start_time', null)
                    ->get() as $event
            ) {

                if (! is_null($event->tag_id) && ! empty($event->channels)) {

                    foreach (json_decode($event->channels) as $channelId) {
                        TagOnItem::create([
                            'item_id' => $channelId,
                            'type' => 'channel',
                            'tag_id' => $event->tag_id,
                        ]);
                    }
                }

                if (! is_null($event->sftp_server_id) && ! is_null($event->banner_path)) {
                    $availableBannersNames = Event::BANNER_NAMES;
                    // upload banner to sftp server
                    // check if file exists
                    if (Storage::exists($event->banner_path)) {
                        $file = Storage::get($event->banner_path);

                        $sftp = new SFTP($event->sftp_server->url);

                        if (! $sftp->login($event->sftp_server->username, $event->sftp_server->password)) {
                            return false;
                        }

                        if (! $sftp->chdir($event->sftp_server->path_to_folder)) {
                            return false;
                        }

                        foreach ($availableBannersNames as $bannerName) {
                            if (! $sftp->put($bannerName, $file)) {
                                return false;
                            }
                        }
                    }
                }
                Mail::to($event->creator)->queue(new SendEventWasStartedMail($event));

                return true;
            }
        }

        return false;
    }
}
