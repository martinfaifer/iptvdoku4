<?php

namespace App\Http\Controllers\Api\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiIndexNanguIspsResource;

class ApiNanguIspController extends Controller
{
    public function index(Request $request)
    {
        return new ApiIndexNanguIspsResource($request);
    }
}
