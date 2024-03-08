<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public array $iptv_dohled_alerts;

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
