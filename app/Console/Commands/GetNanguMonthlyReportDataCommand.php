<?php

namespace App\Console\Commands;

use App\Models\NanguSubscriber;
use Illuminate\Console\Command;
use App\Services\Api\NanguTv\NanguSubscriberService;

class GetNanguMonthlyReportDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nangu:get-monthly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting monthly data reports for creating invoices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // delete all records
        NanguSubscriber::get()->each(function($subscriber) {
            $subscriber->delete();
        });
        // dd();
        // get subscribers
        (new NanguSubscriberService())->get();
        // get subscriptions belongs to subscribers

        // get stb account codes belongs to subscriptions

        // get stbs belongs to stb account codes
    }
}
