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

    public function show_settings_link(User $user): bool
    {
        if ($user->isReader() || $user->isApi()) {
            return false;
        }

        return true;
    }

    public function show_settings_dashboard(User $user): bool
    {
        if ($user->isReader() || $user->isApi()) {
            return false;
        }

        return true;
    }

    public function show_settings_tags(User $user): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_settings_users(User $user): bool
    {
        return false;
    }

    public function show_settings_devices(User $user): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_settings_notifications(User $user): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_settings_channels(User $user): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function show_settings_channels_restart(User $user): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_ip_prefixes(User $user): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_iptv_monitoring(User $user): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_settings_channels_banners(User $user): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function show_settings_channels_multicast_sources(User $user): bool
    {
        if ($user->isTechnik()) {
            return true;
        }

        return false;
    }

    public function show_settings_nangu(User $user): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function show_settings_logs(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function show_settings_geniustv(User $user): bool
    {
        if ($user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function show_tickets(User $user): bool
    {
        if ($user->isReader() || $user->isApi()) {
            return false;
        }

        return true;
    }

    public function show_channels_programers(User $user): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }

    public function show_settings_channels_programmes(User $user): bool
    {
        if ($user->isTechnik() || $user->isAdministrativa()) {
            return true;
        }

        return false;
    }
}
