<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Invoices\CreateNanguInvoicePerIsp;

class CreateNanguIspsInvoiceForThisMonthCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:create-nangu-isps-for-this-month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comamnd for create nangu isps invoice for this month, only for single uses, if anythinks breaks ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new CreateNanguInvoicePerIsp())->create();
    }
}
