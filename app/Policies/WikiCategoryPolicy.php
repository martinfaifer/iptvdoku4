<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WikiCategory;

class WikiCategoryPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WikiCategory $wikiCategory): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->isReader() || $user->isApi()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WikiCategory $wikiCategory): bool
    {
        if ($user->isReader() || $user->isApi()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WikiCategory $wikiCategory): bool
    {
        if ($user->isReader() || $user->isApi()) {
            return false;
        }

        return true;
    }

    public function view_categories(User $user)
    {
        if ($user->isApi()) {
            return false;
        }

        return true;
    }
}
