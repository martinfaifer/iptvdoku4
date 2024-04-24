<?php

namespace App\Traits\Api;

trait RequestTypeTrait
{
    public function get_request_type($method)
    {
        return match ($method) {
            'get' => 'get',
            'post' => 'post',
            'delete' => 'delete'
        };
    }
}
