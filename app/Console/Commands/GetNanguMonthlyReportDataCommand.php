<?php

namespace App\Console\Commands;

use App\Models\NanguStb;
use App\Models\NanguStbAccountCode;
use App\Models\NanguSubscriber;
use App\Models\NanguSubscription;
use App\Services\Api\NanguTv\NanguChannelsService;
use App\Services\Api\NanguTv\NanguOffersService;
use App\Services\Api\NanguTv\NanguStbService;
use App\Services\Api\NanguTv\NanguSubscribersService;
use App\Services\Api\NanguTv\NanguSubscriptionsService;
use App\Services\Invoices\CreateNanguInvoicePerIsp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

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
        Artisan::call('course:get-current');
        // delete all records
        NanguStb::query()->delete();
        NanguStbAccountCode::query()->delete();
        NanguSubscription::query()->delete();
        NanguSubscriber::query()->delete();
        // get subscribers
        (new NanguSubscribersService())->get();
        // get subscriptions belongs to subscribers
        (new NanguSubscriptionsService())->get();
        (new NanguSubscriptionsService())->getInfo();
        //
        (new NanguOffersService())->getInfo();

        // get channels
        (new NanguChannelsService())->get_channels_by_channels_packages_code();

        // get stb account codes belongs to subscriptions

        // get stbs belongs to stb account codes
        (new NanguStbService())->get_stbs();
        // calculate invoices
        (new CreateNanguInvoicePerIsp())->create();

        // create channels usage per NanguISP
        (new NanguChannelsService())->count_channels_usage_per_isp();
        (new NanguChannelsService())->count_channels_usage_total();
        (new NanguSubscriptionsService())->count_subscriptions_per_isp();
    }
}
