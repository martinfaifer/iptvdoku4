<?php

namespace App\Livewire\Iptv\Devices\Menu;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\DeviceCategory;
use Illuminate\Support\Facades\Cache;

class DevicesMenu extends Component
{

    #[On('update_devices_menu')]
    public function render()
    {
        $categoriesWithDevices = DeviceCategory::with('devices:id,name,device_category_id')->get();
        foreach ($categoriesWithDevices as $category) {
            if (!$category->devices->isEmpty()) {
                foreach ($category->devices as $device) {
                    $nmsCachedData = Cache::get('nms_' . $device->id);
                    rescue(function () use ($device, $nmsCachedData) {
                        $device->nms_status = $nmsCachedData[0]['nms_device_status_id']['nms_device_status_type_id'];
                    });
                }
            }
        }
        return view('livewire.iptv.devices.menu.devices-menu', [
            'categoriesWithDevices' => $categoriesWithDevices
        ]);
    }
}
