<?php

namespace App\Livewire\Forms;

use App\Models\WeatherCity;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsWeatherNotificationForm extends Form
{
    #[Validate('required', message: 'Vyplňte město')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    #[Validate('unique:weather_cities,city', message: 'Toto již existuje')]
    public string $city = '';

    #[Validate('required', message: 'Vyplňte stát')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $state = '';

    public function create(): void
    {
        $this->validate();

        WeatherCity::create([
            'city' => $this->city,
            'state' => $this->state,
        ]);

        $this->reset();
    }
}
