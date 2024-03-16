<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiChannelsResource;
use Illuminate\Http\Request;

class ApiChannelController extends Controller
{
    public function index(Request $request)
    {
        return new ApiChannelsResource($request);
    }
}
