<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\NanguIsp;
use App\Models\NanguSubscriber;
use Illuminate\Console\Command;
use App\Models\NanguSubscription;
use App\Services\Api\FlowEye\ConnectService;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Net\SFTP;

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
        echo "no features ... ";
    }
}
