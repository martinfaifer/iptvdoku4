<?php

namespace App\Traits\Array;

trait FindKeyByValueTrait
{
    public function get_value_key($array, $arraySearcheableKey, $needle)
    {
        foreach ($array as $key => $value) {
            if ($value[$arraySearcheableKey] == $needle) {
                return $value['id'];
            };
        }

        return null;
    }
}
