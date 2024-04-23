<?php

namespace App\Services\Api\OpenWeather;

use Illuminate\Support\Facades\Http;
use App\Services\Api\OpenWeather\OpenWeatherService;

class ConnectService
{

    public function __construct(public string $city, public string $state)
    {
    }

    public function connect()
    {
        $httpResponse = Http::get(
            config('services.api.4.open_weather_map.url')
             . '?q=' . $this->city . ',' . $this->state
             .'&units=metric'
             .'&APPID=' . config('services.api.4.open_weather_map.api_key'));
        if ($httpResponse->ok()) {
            return $httpResponse->json();
            // $this->storeData($httpResponse->json());
        }
    }
}
