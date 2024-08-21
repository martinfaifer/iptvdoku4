<?php

namespace App\Traits\Weather;

trait GetWeatherIconTrait
{
    public function get_icon(array $weather): string
    {
        if (! array_key_exists('description', $weather)) {
            return '/storage/svgs/sunny.svg';
        }

        return match ($weather['description']) {
            str_contains($weather['description'], 'clouds') => '/storage/svgs/clouds.svg',
            str_contains($weather['description'], 'rain') => '/storage/svgs/rain.svg',
            str_contains($weather['description'], 'thunderstorm') => '/storage/svgs/thunderstorm.svg',
            str_contains($weather['description'], 'drizzle') => '/storage/svgs/rain.svg',
            str_contains($weather['description'], 'snow') => '/storage/svgs/snow.svg',
            str_contains($weather['description'], 'mist') => '/storage/svgs/smoke.svg',
            str_contains($weather['description'], 'smoke') => '/storage/svgs/smoke.svg',
            str_contains($weather['description'], 'tornado') => '/storage/svgs/tornado.svg',
            default => '/storage/svgs/sunny.svg',
        };
    }
}
