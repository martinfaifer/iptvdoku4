<?php

namespace App\Actions\Networking;

class GenerateMacAddressAction
{
    public function execute(): string
    {
        return implode(':', str_split(substr(md5(mt_rand()), 0, 12), 2));
    }
}
