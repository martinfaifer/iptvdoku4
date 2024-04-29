<?php

namespace Database\Seeders;

use App\Models\WeatherCity;
use Illuminate\Database\Seeder;

class WeatherCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! WeatherCity::first()) {
            WeatherCity::create([
                'city' => 'Chomutov',
                'state' => 'cz',
            ]);
        }
    }
}
