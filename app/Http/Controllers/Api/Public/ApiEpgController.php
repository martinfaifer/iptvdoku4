<?php

namespace App\Http\Controllers\Api\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiEpgResource;

class ApiEpgController extends Controller
{
    public function __invoke(Request $request)
    {
        return new ApiEpgResource($request);
    }
}
