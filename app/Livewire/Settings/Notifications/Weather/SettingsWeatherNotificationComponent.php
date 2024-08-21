<?php

namespace App\Livewire\Settings\Notifications\Weather;

use Livewire\Component;
use App\Models\WeatherCity;
use Livewire\WithPagination;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateSettingsWeatherNotificationForm;
use App\Livewire\Forms\UpdateSettingsWeatherNotificationForm;

class SettingsWeatherNotificationComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsWeatherNotificationForm $createForm;

    public UpdateSettingsWeatherNotificationForm $updateForm;

    public string $query = '';

    public bool $createModal = false;

    public function openCreateModal(): void
    {
        $this->createForm->reset();

        $this->createModal = true;
    }

    public function create(): mixed
    {
        $this->createForm->create();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Přidáno');
    }

    public function destroy(WeatherCity $weather): mixed
    {
        $weather->delete();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    public function closeDialog(): void
    {
        $this->createForm->reset();

        $this->createModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.notifications.weather.settings-weather-notification-component', [
            'headers' => [
                ['key' => 'city', 'label' => 'Město', 'class' => 'text-white/80'],
                ['key' => 'state', 'label' => 'Stát', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
            'weathers' => WeatherCity::search($this->query)->paginate(5),
        ]);
    }
}
