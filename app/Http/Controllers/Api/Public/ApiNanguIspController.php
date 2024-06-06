<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiIndexNanguIspsResource;
use Illuminate\Http\Request;

class ApiNanguIspController extends Controller
{
    public function index(Request $request)
    {
        return new ApiIndexNanguIspsResource($request);
    }
}
