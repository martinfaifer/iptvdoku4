<?php

namespace App\Console\Commands;

use App\Jobs\GetChannelDetailFromNanguApiJob;
use App\Models\Channel;
use Illuminate\Console\Command;

class GetChannelDetailFromNanguApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channels:get-detail-from-nangu-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting channels details from nangu api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ttl = 3600;

        Channel::get()->each(function ($channel) use ($ttl) {
            GetChannelDetailFromNanguApiJob::dispatch($channel, $ttl);
        });
    }
}
