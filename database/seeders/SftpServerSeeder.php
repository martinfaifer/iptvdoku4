<?php

namespace Database\Seeders;

use App\Models\SftpServer;
use Illuminate\Database\Seeder;

class SftpServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! SftpServer::first()) {
            SftpServer::create([
                'name' => 'Nangu Bannery',
                'url' => 'banner.cho01.iptv.grapesc.cz',
                'username' => 'root',
                'password' => 'tica386PP',
                'path_to_folder' => '/var/www/html/',
            ]);
        }
    }
}
