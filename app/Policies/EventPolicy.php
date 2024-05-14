<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
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
    public function view(User $user, Event $event): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function show_blade_functions(User $user)
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function show_events(User $user)
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }
}
