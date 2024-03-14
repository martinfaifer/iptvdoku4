<?php

use App\Livewire\Auth\Login;

use Illuminate\Support\Facades\Route;
use App\Livewire\Iptv\Channels\IptvChannel;
use App\Livewire\Iptv\Devices\DeviceComponent;
use App\Livewire\Iptv\Calendar\CalendarComponent;
use App\Livewire\Iptv\Cards\SatelitCardComponent;
use App\Livewire\Settings\Tags\SettingsTagComponent;
use App\Livewire\Settings\Users\SettingsUsersComponent;

Route::get('login', Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', IptvChannel::class);
    Route::prefix('channels/{channel?}/{channelType?}')->group(function () {
        Route::get('', IptvChannel::class);
    });

    Route::get('devices/{device?}/{component?}', DeviceComponent::class);

    Route::get('sat-cards/{satelitCard?}', SatelitCardComponent::class);

    Route::get('calendar', CalendarComponent::class);

    Route::prefix('settings')->group(function () {
        Route::get('', SettingsTagComponent::class);
        Route::get('tags', SettingsTagComponent::class);
        Route::get('users', SettingsUsersComponent::class);
    });
});
