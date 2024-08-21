<?php

namespace App\Traits\Devices;

use App\Models\DeviceCategory;
use Illuminate\Support\Facades\Cache;

trait CacheDevicesTrait
{
    public function cache_devices_for_menu(): void
    {
        $categoriesWithDevices = DeviceCategory::with('devices:id,name,device_category_id')->get();
        foreach ($categoriesWithDevices as $category) {
            if (!$category->devices->isEmpty()) {
                foreach ($category->devices as $device) {
                    $nmsCachedData = Cache::get('nms_' . $device->id);

                    try {
                        $device->nms_status = $nmsCachedData[0]['nms_device_status_id']['nms_device_status_type_id']; // @phpstan-ignore-line
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
        }

        Cache::pull('devices_menu');
        Cache::forever('devices_menu', $categoriesWithDevices);
    }

    public function cache_device_for_nms_data(): void
    {
        //
    }

    public function get_only_offline_devices(): array
    {
        $offlineDevices = [];
        if (!Cache::has('devices_menu')) {
            return $offlineDevices;
        }
        foreach (Cache::get('devices_menu') as $category) {
            foreach ($category->devices as $device) {
                if (isset($device->nms_status) && $device->nms_status == 3) {
                    $offlineDevices[] = $device;
                }
            }
        }

        return $offlineDevices;
    }
}
