<?php

namespace Database\Seeders;

use App\Models\SatelitCardVendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatelitCardVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!SatelitCardVendor::first()) {

            SatelitCardVendor::create([
                'name' => "Skylink"
            ]);

            SatelitCardVendor::create([
                'name' => "UPC direct"
            ]);

            SatelitCardVendor::create([
                'name' => "Irdeto Premium"
            ]);

            SatelitCardVendor::create([
                'name' => "Discovery/Eurosport"
            ]);

            SatelitCardVendor::create([
                'name' => "Viacom CBS"
            ]);

            SatelitCardVendor::create([
                'name' => "Antik Telecom"
            ]);
        }
    }
}
