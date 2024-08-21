<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\Factory;
use App\Traits\Devices\CacheDevicesTrait;

class NavbarStreamsNotificationComponent extends Component
{
    use CacheDevicesTrait;

    public array $iptv_dohled_alerts = [];
    public array $othersAlerts = [];
    public bool $alertDrawer = false;

    public function mount(): void
    {
        $this->refreshAlerts();
    }

    public function openAlertDrawer(): void
    {
        $this->alertDrawer = true;
    }

    #[On('echo:iptvAlerts,BroadcastIptvDohledAlertsEvent')]
    public function refreshAlerts(): void
    {
        if (Cache::has('iptv_dohled_alerts')) {
            $this->iptv_dohled_alerts = Cache::get('iptv_dohled_alerts');
        } else {
            $this->iptv_dohled_alerts = [];
        }
        $this->getOthersAlerts();
    }

    public function getOthersAlerts(): void
    {
        $this->othersAlerts = [
            'devices' => $this->get_only_offline_devices()
        ];
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.navbar-streams-notification-component');
    }
}
