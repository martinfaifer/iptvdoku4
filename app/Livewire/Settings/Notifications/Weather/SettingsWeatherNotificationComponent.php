<?php

namespace App\Livewire\Settings\Notifications\Weather;

use Livewire\Component;
use App\Models\WeatherCity;
use Livewire\WithPagination;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateSettingsWeatherNotificationForm;
use App\Livewire\Forms\UpdateSettingsWeatherNotificationForm;

class SettingsWeatherNotificationComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsWeatherNotificationForm $createForm;
    public UpdateSettingsWeatherNotificationForm $updateForm;

    public string $query = "";

    public bool $createModal = false;

    public function openCreateModal()
    {
        $this->createForm->reset();
        return $this->createModal = true;
    }

    public function create()
    {
        $this->createForm->create();

        $this->redirect(url()->previous(), true);

        return $this->success_alert("Přidáno");
    }

    public function destroy(WeatherCity $weather)
    {
        $weather->delete();

        $this->redirect(url()->previous(), true);

        return $this->success_alert("Odebráno");
    }

    public function render()
    {
        return view('livewire.settings.notifications.weather.settings-weather-notification-component', [
            'headers' => [
                ['key' => 'city', 'label' => 'Město', 'class' => 'text-white/80'],
                ['key' => 'state', 'label' => 'Stát', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
            'weathers' => WeatherCity::search($this->query)->paginate(5)
        ]);
    }
}
