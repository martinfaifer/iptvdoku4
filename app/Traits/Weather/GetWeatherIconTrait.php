<?php

namespace App\Traits\Weather;

trait GetWeatherIconTrait
{
    public function get_icon($weather)
    {
        if (! array_key_exists('description', $weather)) {
            return '/storage/svgs/sunny.svg';
        }
        switch ($weather) {
            case str_contains($weather['description'], 'clouds'):
                return '/storage/svgs/clouds.svg';
                break;
            case str_contains($weather['description'], 'rain'):
                return '/storage/svgs/rain.svg';
                break;
            case str_contains($weather['description'], 'thunderstorm'):
                return '/storage/svgs/thunderstorm.svg';
                break;
            case str_contains($weather['description'], 'drizzle'):
                return '/storage/svgs/rain.svg';
                break;
            case str_contains($weather['description'], 'snow'):
                return '/storage/svgs/snow.svg';
                break;
            case str_contains($weather['description'], 'mist'):
                return '/storage/svgs/smoke.svg';
                break;
            case str_contains($weather['description'], 'smoke'):
                return '/storage/svgs/smoke.svg';
                break;
            case str_contains($weather['description'], 'tornado'):
                return '/storage/svgs/tornado.svg';
                break;
            default:
                return '/storage/svgs/sunny.svg';
                break;
        }
    }
}
