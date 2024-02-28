<?php

namespace App\Traits\Channels;

use App\Models\GeniusTvChannelPackage;

trait GetGeniusTvChannelPaclagesTrait
{
    public function get_packages(array|null $packagesIds = null): array
    {
        $packages = [];

        if (is_null($packagesIds)) {
            return $packages;
        }

        foreach ($packagesIds as $packageId) {
            $packages[] = GeniusTvChannelPackage::find($packageId)->name;
        }

        return $packages;
    }
}
