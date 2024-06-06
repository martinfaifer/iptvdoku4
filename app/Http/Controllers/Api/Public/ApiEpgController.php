<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiEpgResource;
use Illuminate\Http\Request;

class ApiEpgController extends Controller
{
    public function __invoke(Request $request)
    {
        return new ApiEpgResource($request);
    }
}
