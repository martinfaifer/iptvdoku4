<?php

namespace App\Traits\Network;

trait CheckIfPortIsOpenTrait
{
    public function check_port(string $url, int $portNumber): bool
    {
        $fp = @fsockopen(trim($url), $portNumber, $errno, $errstr, 2);

        return (!$fp) ? false : true;
    }
}
