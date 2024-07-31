<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Cache;
use App\Traits\Devices\CacheDevicesTrait;

class NavbarStreamsNotificationComponent extends Component
{
    use CacheDevicesTrait;

    public array $iptv_dohled_alerts = [];
    public array $othersAlerts = [];
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
        $this->getOthersAlerts();
    }

    public function getOthersAlerts()
    {
        $this->othersAlerts = [
            'devices' => $this->get_only_offline_devices()
        ];
    }

    public function render()
    {
        return view('livewire.navbar-streams-notification-component');
    }
}
