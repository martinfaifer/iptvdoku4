<?php

namespace Database\Seeders;

use App\Models\DeviceVendor;
use Illuminate\Database\Seeder;

class DeviceVendorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! DeviceVendor::first()) {

            DeviceVendor::create([
                'name' => 'Blankom',
            ]);

            DeviceVendor::create([
                'name' => 'FTE',
            ]);

            DeviceVendor::create([
                'name' => 'NoisyPeak',
            ]);

            DeviceVendor::create([
                'name' => 'nVidia',
            ]);

            DeviceVendor::create([
                'name' => 'Cisco',
            ]);

            DeviceVendor::create([
                'name' => 'Titan',
            ]);

            DeviceVendor::create([
                'name' => 'Atlanta',
            ]);

            DeviceVendor::create([
                'name' => 'ProStream',
            ]);

            DeviceVendor::create([
                'name' => 'Nimble',
            ]);

            DeviceVendor::create([
                'name' => 'Linux',
            ]);

            DeviceVendor::create([
                'name' => 'Neznámé',
            ]);
        }
    }
}
