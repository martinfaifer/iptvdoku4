<?php

namespace Database\Seeders;

use App\Models\DeviceCategory;
use Illuminate\Database\Seeder;

class DeviceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! DeviceCategory::first()) {

            DeviceCategory::create([
                'name' => 'Multiplexor',
                'icon' => 'public/svgs/multiplex.svg',
            ]);

            DeviceCategory::create([
                'name' => 'Satelitní přijímač',
                'icon' => 'public/svgs/satellite-uplink.svg',
            ]);

            DeviceCategory::create([
                'name' => 'Transcoder',
                'icon' => 'public/svgs/gpu.svg',
            ]);

            DeviceCategory::create([
                'name' => 'Po IP',
                'icon' => 'public/svgs/ip.svg',
            ]);

            DeviceCategory::create([
                'name' => 'Linux',
                'icon' => 'public/svgs/linux.svg',
            ]);

            DeviceCategory::create([
                'name' => 'Satelity',
                'icon' => 'public/svgs/satellite.svg',
            ]);

            DeviceCategory::create([
                'name' => 'Paraboly',
                'icon' => 'public/svgs/parabola.svg',
            ]);

            DeviceCategory::create([
                'name' => 'Multiswitche',
                'icon' => 'public/svgs/network-switch-line.svg',
            ]);
        }
    }
}
