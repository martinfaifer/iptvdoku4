<?php

namespace App\Traits\Channels;

use App\Models\GeniusTvChannelPackage;

trait GetGeniusTvChannelPaclagesTrait
{
    public function get_packages(?array $packagesIds = null): array
    {
        $packages = [];

        if (blank($packagesIds)) {
            return $packages;
        }

        foreach ($packagesIds as $packageId) {
            $packages[] = GeniusTvChannelPackage::find($packageId)->name;  // @phpstan-ignore-line
        }

        return $packages;
    }
}
