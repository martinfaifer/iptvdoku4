<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Swap\Builder;

class GetEcchangeRateCourseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:get-current';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting current course';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $swap = (new Builder())
            ->add('fixer', ['access_key' => '5d207d6ea5eedb591e0c32e05adb0259'])
            ->add('currency_layer', ['access_key' => 'secret', 'enterprise' => false])
            ->add('european_central_bank')
            ->add('central_bank_of_czech_republic')
            ->build();

        $currencies = Currency::where('name', "!=", "CZK")->get();
        foreach ($currencies as $currency) {
            $currency->update([
                'price' => $swap->latest($currency->name . "/CZK")->getValue()
            ]);
        }
    }
}
