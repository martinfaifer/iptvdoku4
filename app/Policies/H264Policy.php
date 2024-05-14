<?php

namespace App\Policies;

use App\Models\H264;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class H264Policy
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
    public function view(User $user, H264 $h264): bool
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
    public function update(User $user, H264 $h264): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, H264 $h264): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }
}
