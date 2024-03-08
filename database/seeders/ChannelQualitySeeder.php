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
                'format' => 'H264',
            ]);

            ChannelQuality::create([
                'name' => '720',
                'bitrate' => 3200,
                'format' => 'H264',
            ]);

            ChannelQuality::create([
                'name' => '576',
                'bitrate' => 2200,
                'format' => 'H264',
            ]);

            ChannelQuality::create([
                'name' => '404',
                'bitrate' => 1800,
                'format' => 'H264',
            ]);

            ChannelQuality::create([
                'name' => '1080',
                'bitrate' => 3000,
                'format' => 'H265',
            ]);

            ChannelQuality::create([
                'name' => '720',
                'bitrate' => 1700,
                'format' => 'H265',
            ]);
        }
    }
}
