<?php

namespace Database\Seeders;

use App\Models\DeviceSnmp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSnmpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!DeviceSnmp::first()) {
            DeviceSnmp::create([
                'name' => "1"
            ]);

            DeviceSnmp::create([
                'name' => "2c"
            ]);
        }
    }
}
