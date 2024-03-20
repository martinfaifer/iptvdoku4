<?php

namespace App\Livewire\Weather;

use App\Traits\Weather\GetCachedWeatherTrait;
use Livewire\Component;

class WeatherComponent extends Component
{
    use GetCachedWeatherTrait;

    public array $weathers;

    public function mount()
    {
        $this->weathers = $this->get_weathers();
    }

    public function render()
    {
        return view('livewire.weather.weather-component');
    }
}
