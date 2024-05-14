<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChannelPolicy
{
    public function before(User $user): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
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
    public function update(User $user, Channel $channel): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Channel $channel): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }


    public function operate_with_childs(User $user): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }
}
