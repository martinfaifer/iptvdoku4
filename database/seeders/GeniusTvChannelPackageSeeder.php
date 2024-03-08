<?php

namespace Database\Seeders;

use App\Models\GeniusTvChannelPackage;
use Illuminate\Database\Seeder;

class GeniusTvChannelPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! GeniusTvChannelPackage::first()) {

            GeniusTvChannelPackage::create([
                'name' => 'G.TV Základ',
            ]);

            GeniusTvChannelPackage::create([
                'name' => 'G.TV Standard',
            ]);

            GeniusTvChannelPackage::create([
                'name' => 'G.TV Komplet',
            ]);

            GeniusTvChannelPackage::create([
                'name' => 'G.TV Plus',
            ]);

            GeniusTvChannelPackage::create([
                'name' => 'G.TV Filmbox',
            ]);

            GeniusTvChannelPackage::create([
                'name' => 'G.TV HBO',
            ]);

            GeniusTvChannelPackage::create([
                'name' => 'G.TV Cinemax',
            ]);

            GeniusTvChannelPackage::create([
                'name' => 'G.TV HBO MAX',
            ]);

            GeniusTvChannelPackage::create([
                'name' => 'G.TV 4K',
            ]);

            GeniusTvChannelPackage::create([
                'name' => 'G.TV Sport',
            ]);

        }
    }
}
