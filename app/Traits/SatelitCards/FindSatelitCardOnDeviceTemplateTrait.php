<?php

namespace App\Traits\SatelitCards;

use App\Models\Device;
use App\Models\SatelitCard;

trait FindSatelitCardOnDeviceTemplateTrait
{
    public function find_card_in_device_template(SatelitCard $satelitCard): Device|false
    {
        if ($device = Device::where('template', 'like', "%karta\":$satelitCard->id,%")->first()) {
            return $device;
        }

        return false;
    }
}
