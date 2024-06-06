<?php

namespace App\Traits\Users;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

trait GetUsersFromCacheTrait
{
    public function get_users_from_cache()
    {
        if (! Cache::has('users')) {
            Cache::forever('users', User::orderBy('first_name', 'ASC')->get());
        }

        return Cache::get('users');
    }
}
