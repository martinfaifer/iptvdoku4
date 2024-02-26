<?php

use App\Livewire\Auth\Login;
use App\Livewire\Iptv\Channels\IptvChannel;
use App\Livewire\Iptv\Devices\DeviceComponent;
use Illuminate\Support\Facades\Route;

Route::get('login', Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get("/", IptvChannel::class);
    Route::prefix("channels/{channel?}/{channelType?}")->group(function () {
        Route::get("", IptvChannel::class);
    });

    Route::get("devices/{device?}/{component?}", DeviceComponent::class);
});
