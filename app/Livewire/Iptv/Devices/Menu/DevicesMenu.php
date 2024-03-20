<?php

namespace App\Livewire\Iptv\Devices\Menu;

use App\Models\DeviceCategory;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class DevicesMenu extends Component
{
    public $categoriesWithDevices;

    public function mount()
    {
        $this->loadDevices();
    }

    #[On('echo:refresh-devices-menu,BroadcastDevicesMenuEvent')]
    #[On('update_devices_menu')]
    public function loadDevices()
    {
        $this->categoriesWithDevices = DeviceCategory::with('devices:id,name,device_category_id')->get();
        foreach ($this->categoriesWithDevices as $category) {
            if (!$category->devices->isEmpty()) {
                foreach ($category->devices as $device) {
                    $nmsCachedData = Cache::get('nms_' . $device->id);

                    if (!is_null($nmsCachedData) && array_key_exists(0, $nmsCachedData)) {
                        $device->nms_status = $nmsCachedData[0]['nms_device_status_id']['nms_device_status_type_id'];
                    }
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.iptv.devices.menu.devices-menu');
    }
}
