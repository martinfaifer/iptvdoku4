<?php

namespace App\Policies;

use App\Models\SftpServer;
use App\Models\User;

class SftpPolicy
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
    public function view(User $user, SftpServer $sftpServer): bool
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
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SftpServer $sftpServer): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SftpServer $sftpServer): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_servers(User $user): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function upload(User $user): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }
}
