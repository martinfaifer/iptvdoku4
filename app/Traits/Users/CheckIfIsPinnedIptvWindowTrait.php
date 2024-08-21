<?php

namespace App\Traits\Users;

trait CheckIfIsPinnedIptvWindowTrait
{
    public function pinned(string $iptv_monitoring_window): bool
    {
        if ($iptv_monitoring_window == 'closed') {
            return false;
        }

        return true;
    }

    public function convert_response_to_db_string(bool $reponse): string
    {
        if ($reponse == true) {
            return 'maximaze';
        }

        return 'closed';
    }
}
