<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Tag::first()) {

            Tag::create([
                'name' => 'Ukončené vysílaní',
                'color' => "#E70C0C"
            ]);

            Tag::create([
                'name' => 'Nefunkční zařízení',
                'color' => "#B71C1C"
            ]);

            Tag::create([
                'name' => 'Multicast tvořen na transcodéru',
                'color' => "#FF5722"
            ]);

            Tag::create([
                'name' => 'Pozastaveno vysílání',
                'color' => "#B71C1C"
            ]);

            Tag::create([
                'name' => '50fps',
                'color' => "#8E24AA"
            ]);

            Tag::create([
                'name' => 'Kanál v PROMU',
                'color' => "#00BCD4",
                'action' => 2
            ]);

            Tag::create([
                'name' => 'Kontrola GPU',
                'color' => "#00BCD4",
                'action' => 1
            ]);
        }
    }
}
