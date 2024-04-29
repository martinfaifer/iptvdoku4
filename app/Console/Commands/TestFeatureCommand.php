<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestFeatureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feature:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing upcoming features';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo 'no features ... ';
    }
}
