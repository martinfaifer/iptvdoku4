<?php

namespace App\Livewire\Iptv\Devices\Menu;

use App\Traits\Devices\CacheDevicesTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class DevicesMenu extends Component
{
    use CacheDevicesTrait;

    public mixed $categoriesWithDevices;

    public function mount(): void
    {
        $this->loadDevices();
    }

    #[On('echo:refresh-devices-menu,BroadcastDevicesMenuEvent')]
    #[On('update_devices_menu')]
    public function loadDevices(): void
    {
        if (! Cache::has('devices_menu')) {
            $this->cache_devices_for_menu();
        }

        $this->categoriesWithDevices = Cache::get('devices_menu');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.menu.devices-menu');
    }
}
