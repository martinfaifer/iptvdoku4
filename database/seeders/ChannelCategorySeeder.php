<?php

namespace Database\Seeders;

use App\Models\ChannelCategory;
use Illuminate\Database\Seeder;

class ChannelCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! ChannelCategory::first()) {
            ChannelCategory::create([
                'name' => 'Dětský',
            ]);

            ChannelCategory::create([
                'name' => 'Dokumentární',
            ]);

            ChannelCategory::create([
                'name' => 'Erotický',
            ]);

            ChannelCategory::create([
                'name' => 'Filmový',
            ]);

            ChannelCategory::create([
                'name' => 'Hudební',
            ]);

            ChannelCategory::create([
                'name' => 'Interaktivní',
            ]);

            ChannelCategory::create([
                'name' => 'Internetová',
            ]);

            ChannelCategory::create([
                'name' => 'Kultura',
            ]);

            ChannelCategory::create([
                'name' => 'Móda',
            ]);

            ChannelCategory::create([
                'name' => 'Regionální',
            ]);

            ChannelCategory::create([
                'name' => 'Smíšený',
            ]);

            ChannelCategory::create([
                'name' => 'Soukromá',
            ]);

            ChannelCategory::create([
                'name' => 'Sportovní',
            ]);

            ChannelCategory::create([
                'name' => 'Veřejnoprávní',
            ]);

            ChannelCategory::create([
                'name' => 'Zábava',
            ]);

            ChannelCategory::create([
                'name' => 'Zpravodajská',
            ]);
        }
    }
}
