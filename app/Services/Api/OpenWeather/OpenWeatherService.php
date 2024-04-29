<?php

namespace App\Services\Api\OpenWeather;

use App\Actions\Slack\SendSlackNotificationAction;
use App\Models\Slack;
use Illuminate\Support\Facades\Cache;

class OpenWeatherService
{
    public function separate_data($openWeatherResponse): array
    {
        $weather = [
            'main' => $openWeatherResponse['weather'][0]['main'],
            'description' => $openWeatherResponse['weather'][0]['description'],
            'temp' => $openWeatherResponse['main']['temp'],
            'pressure' => $openWeatherResponse['main']['pressure'],
            'humidity' => $openWeatherResponse['main']['humidity'],
            'windSpeed' => $openWeatherResponse['wind']['speed'],
            'location' => $openWeatherResponse['name'],
        ];

        return $weather;
        // store to cache
        // Cache::put('weather_' . $openWeatherResponse['name'], $weather, 3600);
    }

    public function notify_if_necessary(string $weatherDescription)
    {
        Slack::where('action', 'weather_notification')->get()->each(function ($channel) use ($weatherDescription) {
            if (str_contains($weatherDescription, 'thunderstorm')) {
                (new SendSlackNotificationAction(
                    text: ':thunder_cloud_and_rain:    Na dnešní den je očekávána bouřka, může dojít k výpadkům kanálů ze satelitu.',
                    url: $channel->url
                ))();
            }

            if (str_contains($weatherDescription, 'heavy intensity rain')) {
                (new SendSlackNotificationAction(
                    text: ':rain_cloud:    Je očekáván velmi silný déšť, může dojít k výpadkům kanálů ze satelitu.',
                    url: $channel->url
                ))();
            }

            if (str_contains($weatherDescription, 'very heavy rain')) {
                (new SendSlackNotificationAction(
                    text: ':rain_cloud:    Je očekáván velmi silný déšť, může dojít k výpadkům kanálů ze satelitu.',
                    url: $channel->url
                ))();
            }

            if (str_contains($weatherDescription, 'extreme rain')) {
                (new SendSlackNotificationAction(
                    text: ':rain_cloud:    Je očekáván velmi silný déšť, může dojít k výpadkům kanálů ze satelitu.',
                    url: $channel->url
                ))();
            }

            if (str_contains($weatherDescription, 'Heavy snow')) {
                (new SendSlackNotificationAction(
                    text: ':snowflake:    Je očekáváno silné sněžení, může dojít k výpadkům kanálů ze satelitu.',
                    url: $channel->url
                ))();
            }
        });
    }
}
