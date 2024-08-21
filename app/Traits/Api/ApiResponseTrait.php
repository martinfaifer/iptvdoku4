<?php

namespace App\Traits\Api;

trait ApiResponseTrait
{
    public function succes_response(mixed $data): array
    {
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }

    public function not_found_response(): never
    {
        abort(404);
    }
}
