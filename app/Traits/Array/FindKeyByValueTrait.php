<?php

namespace App\Traits\Array;

trait FindKeyByValueTrait
{
    public function get_value_key(array $array, string $arraySearcheableKey, string $needle): mixed
    {
        foreach ($array as $key => $value) {
            if ($value[$arraySearcheableKey] == $needle) {
                return $value['id'];
            }
        }

        return null;
    }
}
