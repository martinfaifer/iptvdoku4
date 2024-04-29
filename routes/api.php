<?php

use App\Http\Controllers\Api\Public\ApiChannelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('public')->group(function () {
        Route::get('channels', [ApiChannelController::class, 'index']);
    });
});
