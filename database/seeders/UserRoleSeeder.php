<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! UserRole::where('name', 'admin')->first()) {
            UserRole::create([
                'name' => 'admin',
            ]);
        }

        if (! UserRole::where('name', 'technik')->first()) {
            UserRole::create([
                'name' => 'technik',
            ]);
        }

        if (! UserRole::where('name', 'administrativa')->first()) {
            UserRole::create([
                'name' => 'administrativa',
            ]);
        }

        if (! UserRole::where('name', 'API')->first()) {
            UserRole::create([
                'name' => 'API',
            ]);
        }

        if (! UserRole::where('name', 'reader')->first()) {
            UserRole::create([
                'name' => 'reader',
            ]);
        }
    }
}
