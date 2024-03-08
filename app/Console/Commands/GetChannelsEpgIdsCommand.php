<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Api\Epg\EpgConnectService;

class GetChannelsEpgIdsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epg:get-channels-ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get channels epg ids ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new EpgConnectService())->connect(cacheKey: "channelEpgIds");
    }
}
