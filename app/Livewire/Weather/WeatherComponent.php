<?php

namespace App\Livewire\Weather;

use App\Traits\Weather\GetCachedWeatherTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class WeatherComponent extends Component
{
    use GetCachedWeatherTrait;

    public array $weathers;

    public function mount(): void
    {
        $this->weathers = $this->get_weather();
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.weather.weather-component');
    }
}
