<?php

namespace App\Traits\Prefixes;

trait CidrTrait
{
    public function available_cidrs()
    {
        $cidrs = [];
        for ($i = 0; $i <= 32; $i++) {
            $cidrs[] = [
                'id' => $i,
                'name' => $i,
            ];
        }

        return $cidrs;
    }
}
