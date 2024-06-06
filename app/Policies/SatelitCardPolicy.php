<?php

namespace App\Policies;

use App\Models\SatelitCard;
use App\Models\User;

class SatelitCardPolicy
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
    public function view(User $user, SatelitCard $satelitCard): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
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
    public function update(User $user, SatelitCard $satelitCard): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SatelitCard $satelitCard): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_blade_functions(User $user)
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function view_cards(User $user)
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }
}
