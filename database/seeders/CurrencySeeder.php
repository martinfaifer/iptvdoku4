<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! Currency::first()) {
            Currency::create([
                'name' => 'usd',
            ]);

            Currency::create([
                'name' => 'eu',
            ]);

            Currency::create([
                'name' => 'czk',
            ]);
        }
    }
}
