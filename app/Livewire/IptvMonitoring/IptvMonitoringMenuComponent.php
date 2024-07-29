<?php

namespace App\Livewire\IptvMonitoring;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class IptvMonitoringMenuComponent extends Component
{

    public int $numberOfAlerts = 0;
    public function mount()
    {
        if (!Cache::has('iptv_dohled_all_alerts')) {
            $this->numberOfAlerts = 0;
        } else {
            $this->numberOfAlerts = count(Cache::get('iptv_dohled_all_alerts')['data']);
        }
    }

    public function render()
    {
        return view('livewire.iptv-monitoring.iptv-monitoring-menu-component');
    }
}
