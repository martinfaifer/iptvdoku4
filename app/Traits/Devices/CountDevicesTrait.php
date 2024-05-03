<?php

namespace App\Traits\Devices;

use App\Models\Device;
use App\Models\SatelitCard;

trait CountDevicesTrait
{
    public function count_devices(): int
    {
        return Device::count();
    }

    public function count_sat_cards(): int
    {
        return SatelitCard::count();
    }
}
