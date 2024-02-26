<?php

namespace Database\Seeders;

use App\Models\ChannelSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChannelSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!ChannelSource::first()) {
            ChannelSource::create([
                'name' => "Grape SC"
            ]);

            ChannelSource::create([
                'name' => "Kabel 1"
            ]);

            ChannelSource::create([
                'name' => "WMS"
            ]);

            ChannelSource::create([
                'name' => "CBCnet"
            ]);

            ChannelSource::create([
                'name' => "JMnet"
            ]);

            ChannelSource::create([
                'name' => "RytněNet"
            ]);

            ChannelSource::create([
                'name' => "Sat+ (UPC-CeColo)"
            ]);

            ChannelSource::create([
                'name' => "Sledování TV"
            ]);

            ChannelSource::create([
                'name' => "ITself"
            ]);

            ChannelSource::create([
                'name' => "HBO"
            ]);

            ChannelSource::create([
                'name' => "ČRA"
            ]);

            ChannelSource::create([
                'name' => "SPI Filmbox"
            ]);
        }
    }
}
