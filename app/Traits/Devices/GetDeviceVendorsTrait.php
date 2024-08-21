<?php

namespace App\Traits\Devices;

use App\Models\DeviceVendor;
use Illuminate\Support\Facades\Cache;

trait GetDeviceVendorsTrait
{
    public function get_device_vendors(): mixed
    {
        if (! Cache::has('device_vendors')) {
            Cache::forever('device_vendors', DeviceVendor::get());
        }

        return Cache::get('device_vendors');
    }
}
