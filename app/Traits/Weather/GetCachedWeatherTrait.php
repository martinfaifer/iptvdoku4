<?php

namespace App\Traits\Weather;

use App\Models\WeatherCity;
use Illuminate\Support\Facades\Cache;

trait GetCachedWeatherTrait
{
    public function get_weather(): array
    {
        $weather = [];

        $weatherCity = WeatherCity::first();

        $weather = Cache::get('weather_'.$weatherCity->city);

        if (is_null($weather)) {
            return [];
        }

        return $weather;
    }
}
