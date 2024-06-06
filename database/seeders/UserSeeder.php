<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! User::first()) {
            User::create([
                'first_name' => 'Martin',
                'last_name' => 'Faifer',
                'email' => 'martinfaifer@gmail.com',
                'password' => '1122334455',
                'user_role_id' => 1,
            ]);
        }
    }
}
