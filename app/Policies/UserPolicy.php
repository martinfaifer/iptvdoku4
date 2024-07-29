<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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
    public function view(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }

    public function show_settings_link(User $user)
    {
        if ($user->isReader() || $user->isApi()) {
            return false;
        }

        return true;
    }

    public function show_settings_dashboard(User $user)
    {
        if ($user->isReader() || $user->isApi()) {
            return false;
        }

        return true;
    }

    public function show_settings_tags(User $user)
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_settings_users(User $user)
    {
        return false;
    }

    public function show_settings_devices(User $user)
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_settings_notifications(User $user)
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_settings_channels(User $user)
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function show_settings_channels_restart(User $user)
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_ip_prefixes(User $user)
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_iptv_monitoring(User $user)
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_settings_channels_banners(User $user)
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function show_settings_channels_multicast_sources(User $user)
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_settings_nangu(User $user)
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function show_settings_logs(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function show_settings_geniustv(User $user)
    {
        if ($user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function show_tickets(User $user)
    {
        if ($user->isReader() || $user->isApi()) {
            return false;
        }

        return true;
    }
}
