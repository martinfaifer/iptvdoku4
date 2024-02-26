<?php

namespace Database\Seeders;

use App\Models\DeviceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!DeviceCategory::first()) {

            DeviceCategory::create([
                'name' => "Multiplexor"
            ]);

            DeviceCategory::create([
                'name' => "Satelitní přijímač"
            ]);

            DeviceCategory::create([
                'name' => "Transcoder"
            ]);

            DeviceCategory::create([
                'name' => "Po IP"
            ]);

            DeviceCategory::create([
                'name' => "Linux"
            ]);

            DeviceCategory::create([
                'name' => "Satelity"
            ]);

            DeviceCategory::create([
                'name' => "Paraboly"
            ]);

            DeviceCategory::create([
                'name' => "Multiswitche"
            ]);
        }
    }
}
