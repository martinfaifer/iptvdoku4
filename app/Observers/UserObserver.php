<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Actions\Users\StoreUsersToCacheAction;

class UserObserver
{
    public function created(User $user)
    {
        (new StoreUsersToCacheAction())();
    }

    public function updated(User $user)
    {
        (new StoreUsersToCacheAction())();
    }

    public function deleted(User $user)
    {
        (new StoreUsersToCacheAction())();
    }
}
