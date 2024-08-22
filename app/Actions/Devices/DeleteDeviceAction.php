<?php

namespace App\Actions\Devices;

use App\Models\Alert;
use App\Models\Chart;
use App\Models\Device;
use App\Models\Contact;
use App\Traits\Devices\CacheDevicesTrait;
use App\Jobs\SearchIfSatCardIsUsedInDeviceJob;

class DeleteDeviceAction
{
    use CacheDevicesTrait;
    public function __construct(public Device $device) {}

    public function __invoke(): void
    {
        // delete charts
        Chart::where('item', 'like', '%device:' . $this->device->id . ':%')->delete();
        // delete alerts
        Alert::where('type', 'gpu_check_failed')->where('item_id', $this->device->id)->delete();
        Alert::where('type', 'gpu_problem')->where('item_id', $this->device->id)->delete();
        // delete device contacts
        Contact::where('type', 'device')->where('item_id', $this->device->id)->delete();

        SearchIfSatCardIsUsedInDeviceJob::dispatch();

        // cache devices menu
        $this->cache_devices_for_menu();
    }
}
