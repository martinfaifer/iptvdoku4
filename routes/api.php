<?php

use App\Http\Controllers\Api\Public\ApiChannelController;
use App\Http\Controllers\Api\Public\ApiEpgController;
use App\Http\Controllers\Api\Public\ApiNanguIspController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('public')->group(function () {
        Route::get('channels', [ApiChannelController::class, 'index']);
        Route::get('epg', ApiEpgController::class);
    });

    Route::middleware('auth.basic')->group(function () {
        Route::prefix('nangu')->group(function () {
            Route::prefix('isps')->group(function () {
                Route::get('', [ApiNanguIspController::class, 'index']);
            });
        });
    });
});

// Route::middleware('auth.basic')->group(function () {
Route::prefix('v2')->group(function () {
    Route::prefix('channels')->group(function () {
        Route::get('{channel_url}', [ApiChannelController::class, 'show']);
    });
});
// });
