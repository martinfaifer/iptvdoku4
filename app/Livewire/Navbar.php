<?php

namespace App\Livewire;

use App\Traits\Calendar\RunningEventsTrait;
use App\Traits\Weather\GetCachedWeatherTrait;
use App\Traits\Weather\GetWeatherIconTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    use GetCachedWeatherTrait, GetWeatherIconTrait, RunningEventsTrait;

    public array $iptv_dohled_alerts = [];

    public array $runningEvents;

    public mixed $user;

    public array $weather;

    public bool $alertDrawer = false;

    public array $notifyFromCurrentEvents = [];

    public bool $calendarNotificationDialog = false;

    public bool $calendarEventsDrawer = false;

    public function mount(): void
    {
        $this->runningEvents = $this->running_events();
        $this->user = $this->load_user();
        $this->load_weather();
        // $this->refreshAlerts();

        // check if is running some events to notify in frontEnd
        $this->notifyFromCurrentEvents = $this->running_events_with_frontendNotification();
        if ($this->notifyFromCurrentEvents) {
            if (! session()->has('calendarNotificationDialog')) {
                $this->calendarNotificationDialog = true;
            }
        }
    }

    #[On('echo:refresh_user_data,BroadcastRefreshUserEvent')]
    public function load_user(): mixed
    {
        return Auth::user();
    }

    #[On('echo:refresh_weather,BroadcastWeatherInformationEvent')]
    public function load_weather(): void
    {
        $this->weather = $this->get_weather();
    }

    public function openAlertDrawer(): void
    {
        $this->alertDrawer = true;
    }

    public function openCalendarEventsDrawer(): void
    {
        $this->calendarEventsDrawer = true;
    }

    #[On('echo:iptvAlerts,BroadcastIptvDohledAlertsEvent')]
    public function refreshAlerts(): void
    {
        if (Cache::has('iptv_dohled_alerts')) {
            $this->iptv_dohled_alerts = Cache::get('iptv_dohled_alerts');
        } else {
            $this->iptv_dohled_alerts = [];
        }
    }

    public function closeCalendarNotificationDialog(): void
    {
        session(['calendarNotificationDialog' => 'seen']);

        $this->calendarNotificationDialog = false;
    }

    public function logout(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $this->redirect('/', true);
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.navbar');
    }
}
