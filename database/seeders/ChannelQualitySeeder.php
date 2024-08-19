<?php

namespace Database\Seeders;

use App\Models\ChannelQuality;
use Illuminate\Database\Seeder;

class ChannelQualitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! ChannelQuality::first()) {

            ChannelQuality::create([
                'name' => '1080',
                'bitrate' => 6000,
                'min_bitrate' => 5500,
                'format' => 'H264',
            ]);

            ChannelQuality::create([
                'name' => '720',
                'bitrate' => 3200,
                'min_bitrate' => 2700,
                'format' => 'H264',
            ]);

            ChannelQuality::create([
                'name' => '576',
                'bitrate' => 2200,
                'min_bitrate' => 1700,
                'format' => 'H264',
            ]);

            ChannelQuality::create([
                'name' => '404',
                'bitrate' => 1800,
                'min_bitrate' => 1300,
                'format' => 'H264',
            ]);

            ChannelQuality::create([
                'name' => '1080',
                'bitrate' => 3000,
                'min_bitrate' => 2500,
                'format' => 'H265',
            ]);

            ChannelQuality::create([
                'name' => '720',
                'bitrate' => 1700,
                'min_bitrate' => 1200,
                'format' => 'H265',
            ]);
        }
    }
}
