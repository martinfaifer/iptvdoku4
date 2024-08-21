<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiChannelResource;
use App\Http\Resources\ApiChannelsResource;
use Illuminate\Http\Request;

class ApiChannelController extends Controller
{
    /**
     * This function handles the retrieval of channels for the API.
     *
     * @param  Request  $request  The incoming request object containing parameters and data.
     * @return ApiChannelsResource A resource object containing the requested channels.
     */
    public function index(Request $request): ApiChannelsResource
    {
        return new ApiChannelsResource($request);
    }

    public function show(Request $request): ApiChannelResource
    {
        return new ApiChannelResource($request);
    }
}
