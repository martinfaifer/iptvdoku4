<?php

namespace App\Livewire\Iptv\Devices\Menu;

use App\Models\Device;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\DeviceCategory;
use Illuminate\Support\Facades\Cache;
use App\Traits\Devices\CacheDevicesTrait;

class DevicesMenu extends Component
{
    use CacheDevicesTrait;
    public $categoriesWithDevices;

    public function mount()
    {
        $this->loadDevices();
    }

    #[On('echo:refresh-devices-menu,BroadcastDevicesMenuEvent')]
    #[On('update_devices_menu')]
    public function loadDevices()
    {
        if (!Cache::has('devices_menu')) {
            $this->cache_devices_for_menu();
        }
        return $this->categoriesWithDevices = Cache::get('devices_menu');
    }

    public function render()
    {
        return view('livewire.iptv.devices.menu.devices-menu');
    }
}
