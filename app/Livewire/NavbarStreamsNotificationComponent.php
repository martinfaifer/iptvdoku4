<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Cache;

class NavbarStreamsNotificationComponent extends Component
{
    public array $iptv_dohled_alerts = [];
    public bool $alertDrawer = false;

    public function mount()
    {
        $this->refreshAlerts();
    }

    public function openAlertDrawer()
    {
        return $this->alertDrawer = true;
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
        return view('livewire.navbar-streams-notification-component');
    }
}
