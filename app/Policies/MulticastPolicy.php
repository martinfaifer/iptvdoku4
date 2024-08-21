<?php

namespace App\Policies;

use App\Models\ChannelMulticast;
use App\Models\User;

class MulticastPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ChannelMulticast $multicast): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ChannelMulticast $multicast): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ChannelMulticast $multicast): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }
}
