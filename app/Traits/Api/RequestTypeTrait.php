<?php

namespace App\Traits\Api;

trait RequestTypeTrait
{
    public function get_request_type(string $method = 'get'): string
    {
        return match ($method) {
            'get' => 'get',
            'post' => 'post',
            'delete' => 'delete',
            default => 'get'
        };
    }
}
