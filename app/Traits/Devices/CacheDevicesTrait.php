<?php

namespace App\Traits\Devices;

use App\Models\DeviceCategory;
use Illuminate\Support\Facades\Cache;

trait CacheDevicesTrait
{
    public function cache_devices_for_menu()
    {
        $categoriesWithDevices = DeviceCategory::with('devices:id,name,device_category_id')->get();
        foreach ($categoriesWithDevices as $category) {
            if (! $category->devices->isEmpty()) {
                foreach ($category->devices as $device) {
                    $nmsCachedData = Cache::get('nms_'.$device->id);

                    try {
                        $device->nms_status = $nmsCachedData[0]['nms_device_status_id']['nms_device_status_type_id'];
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
        }

        Cache::pull('devices_menu');
        Cache::forever('devices_menu', $categoriesWithDevices);
    }

    public function cache_device_for_nms_data()
    {
        //
    }
}
