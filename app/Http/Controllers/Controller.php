<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function api_error(string $message)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], 404);
    }

    public function api_success($data)
    {
        return response()->json([
            'status' => 'success',
            'message' => $data,
        ], 200);
    }
}
