<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ChannelCategorySeeder::class,
            ChannelSourceSeeder::class,
            ChannelQualitySeeder::class,
            DeviceCategorySeeder::class,
            DeviceVendorsSeeder::class,
            DeviceSnmpSeeder::class,
            DeviceVendorSnmpSeeder::class,
            GeniusTvChannelPackageSeeder::class,
            TagSeeder::class,
            CssColorSeeder::class,
            SatelitCardVendorSeeder::class,
            NanguIspSeeder::class,
            SftpServerSeeder::class,
            WeatherCitySeeder::class
        ]);
    }
}
