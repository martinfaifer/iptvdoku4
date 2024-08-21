<?php

namespace App\Console\Commands;

use App\Services\Invoices\CreateNanguInvoicePerIsp;
use Illuminate\Console\Command;

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
    public function handle(): void
    {
        (new CreateNanguInvoicePerIsp())->create();
    }
}
