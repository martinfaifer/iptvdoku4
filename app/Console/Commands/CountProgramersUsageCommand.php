<?php

namespace App\Console\Commands;

use App\Traits\Programmers\CountProgrammersUsageTrait;
use Illuminate\Console\Command;

class CountProgramersUsageCommand extends Command
{
    use CountProgrammersUsageTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'programers:count_usage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count programmers usage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->count_programmers_usage();
    }
}
