<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class StoreUsersToCacheAction
{
    public function __construct()
    {
        //
    }

    public function __invoke()
    {
        if (Cache::has('users')) {
            Cache::forget('users');
        }

        Cache::forever('users', User::ordedBy('first_name', "ASC")->get());
    }
}
