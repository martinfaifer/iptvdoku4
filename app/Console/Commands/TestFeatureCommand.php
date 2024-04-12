<?php

namespace App\Console\Commands;

use App\Models\NanguIsp;
use App\Models\NanguSubscriber;
use Illuminate\Console\Command;
use App\Models\NanguSubscription;
use Spatie\LaravelPdf\Facades\Pdf;

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
        Pdf::view('pdfs.invoice')->save(public_path('storage/invoices/test.pdf'));
    }
}
