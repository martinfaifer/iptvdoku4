<?php

namespace App\Console\Commands;

use App\Jobs\GetAlertsFromIptvDohledJob;
use Illuminate\Console\Command;

class GetIptvDohledAlertsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iptv-dohled:alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get alerts from iptv dohled about crashed streams';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        GetAlertsFromIptvDohledJob::dispatch();
    }
}
