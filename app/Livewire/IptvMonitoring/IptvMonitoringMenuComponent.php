<?php

namespace App\Livewire\IptvMonitoring;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class IptvMonitoringMenuComponent extends Component
{
    public int $numberOfAlerts = 0;

    public function mount(): void
    {
        if (! Cache::has('iptv_dohled_all_alerts')) {
            $this->numberOfAlerts = 0;
        } else {
            $this->numberOfAlerts = count(Cache::get('iptv_dohled_all_alerts')['data']);
        }
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv-monitoring.iptv-monitoring-menu-component');
    }
}
