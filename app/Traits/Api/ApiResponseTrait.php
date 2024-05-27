<?php

namespace App\Traits\Api;

trait ApiResponseTrait
{
    public function succes_response($data)
    {
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }

    public function not_found_response()
    {
        return abort(404);
    }
}
