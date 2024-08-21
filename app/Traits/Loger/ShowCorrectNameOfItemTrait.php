<?php

namespace App\Traits\Loger;

use App\Models\Channel;
use App\Models\Device;
use App\Models\SatelitCard;

trait ShowCorrectNameOfItemTrait
{
    public function show_log_item(string $item): ?string
    {
        $explodedItem = explode(':', $item);

        return match ($explodedItem[0]) {
            'device' => Device::find($explodedItem[1])?->name,
            'channel' => Channel::find($explodedItem[1])?->name,
            'multicast' => Channel::find($explodedItem[1])?->name,
            'h264' => Channel::find($explodedItem[1])?->name,
            'h265' => Channel::find($explodedItem[1])?->name,
            'satelit_card' => SatelitCard::find($explodedItem[1])?->name,
            default => $item,
        };
    }
}
