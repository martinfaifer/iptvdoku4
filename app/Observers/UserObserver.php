<?php

namespace App\Observers;

use App\Actions\Users\StoreUsersToCacheAction;
use App\Models\User;

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
