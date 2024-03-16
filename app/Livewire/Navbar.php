<?php

namespace App\Livewire;

use App\Traits\Calendar\RunningEventsTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    use RunningEventsTrait;

    public array $iptv_dohled_alerts;

    public array $runningEvents;

    public function mount()
    {
        $this->runningEvents = $this->running_events();
    }

    #[On('echo:iptvAlerts,BroadcastIptvDohledAlertsEvent')]
    public function refreshAlerts()
    {
        $this->iptv_dohled_alerts = Cache::get('iptv_dohled_alerts');
    }

    public function render()
    {
        return view('livewire.navbar', [
            'iptv_dohled_alerts' => Cache::get('iptv_dohled_alerts'),
        ]);
    }
}
