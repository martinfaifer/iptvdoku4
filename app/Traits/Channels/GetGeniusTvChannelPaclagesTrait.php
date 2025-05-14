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
            $packages[] = GeniusTvChannelPackage::where('id', $packageId)->first()->name;  // @phpstan-ignore-line
        }

        return $packages;
    }

    public function get_main_packages(?array $packagesIds = null): array
    { {
            $packages = [];

            if (blank($packagesIds)) {
                return $packages;
            }

            foreach ($packagesIds as $packageId) {
                $mainPackage = GeniusTvChannelPackage::where('id', $packageId)->where('is_optional', false)->first();
                if ($mainPackage) {
                    $packages[] = $mainPackage->name;  // @phpstan-ignore-line
                }
            }

            return $packages;
        }
    }

    public function get_optional_packages(?array $packagesIds = null): array
    { {
            $packages = [];

            if (blank($packagesIds)) {
                return $packages;
            }

            foreach ($packagesIds as $packageId) {
                $optionalPackage = GeniusTvChannelPackage::where('id', $packageId)->where('is_optional', true)->first();
                if ($optionalPackage) {
                    $packages[] = $optionalPackage->name;  // @phpstan-ignore-line
                }
            }

            return $packages;
        }
    }
}
