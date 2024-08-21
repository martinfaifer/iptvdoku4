<?php

namespace App\Console\Commands;

use App\Events\BroadcastWeatherInformationEvent;
use App\Models\WeatherCity;
use App\Services\Api\OpenWeather\ConnectService;
use App\Services\Api\OpenWeather\OpenWeatherService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GetWeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting weather forecast for cities in database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $weatherService = new OpenWeatherService();
        WeatherCity::get()->each(function ($cityWithState) use ($weatherService) {
            $weatherResponse = (new ConnectService(
                city: $cityWithState->city,
                state: $cityWithState->state
            ))->connect();

            $separatedWeather = $weatherService->separate_data($weatherResponse);

            // store to cache
            Cache::put('weather_'.$cityWithState->city, $separatedWeather, 7200);

            // send notification if need to be
            $weatherService->notify_if_necessary($separatedWeather['description']);

            // broadcast information to frontend
            BroadcastWeatherInformationEvent::dispatch();
        });
    }
}
