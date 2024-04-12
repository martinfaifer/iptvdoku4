<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Traits\Calendar\RunningEventsTrait;
use App\Traits\Weather\GetCachedWeatherTrait;

class Navbar extends Component
{
    use RunningEventsTrait, GetCachedWeatherTrait;

    public array $iptv_dohled_alerts;

    public array $runningEvents;

    public $user;

    public array $weather;

    public bool $alertDrawer = false;

    public bool $calendarEventsDrawer = false;

    public function mount()
    {
        $this->runningEvents = $this->running_events();
        $this->user = Auth::user();
        $this->weather = $this->get_weather();
    }

    public function openAlertDrawer()
    {
        return $this->alertDrawer = true;
    }

    public function openCalendarEventsDrawer()
    {
        return $this->calendarEventsDrawer = true;
    }

    #[On('echo:iptvAlerts,BroadcastIptvDohledAlertsEvent')]
    public function refreshAlerts()
    {
        if (Cache::has('iptv_dohled_alerts')) {
            $this->iptv_dohled_alerts = Cache::get('iptv_dohled_alerts');
        } else {
            $this->iptv_dohled_alerts = [];
        }
    }

    public function render()
    {
        return view('livewire.navbar', [
            'iptv_dohled_alerts' => Cache::get('iptv_dohled_alerts'),
        ]);
    }
}
