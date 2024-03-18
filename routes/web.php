<?php

use App\Livewire\Auth\Login;

use Illuminate\Support\Facades\Route;
use App\Livewire\Iptv\Channels\IptvChannel;
use App\Livewire\Iptv\Devices\DeviceComponent;
use App\Livewire\Iptv\Calendar\CalendarComponent;
use App\Livewire\Iptv\Cards\SatelitCardComponent;
use App\Livewire\Iptv\Sftps\SftpComponent;
use App\Livewire\Settings\Tags\SettingsTagComponent;
use App\Livewire\Settings\Users\SettingsUsersComponent;
use App\Livewire\Settings\Nangu\Isps\SettingsIspComponent;
use App\Livewire\Settings\Nangu\Isps\SettingsTagToChannelPackageComponent;

Route::get('login', Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', IptvChannel::class);
    Route::prefix('channels/{channel?}/{channelType?}')->group(function () {
        Route::get('', IptvChannel::class);
    });

    Route::get('devices/{device?}/{component?}', DeviceComponent::class);

    Route::get('sat-cards/{satelitCard?}', SatelitCardComponent::class);

    Route::get('calendar', CalendarComponent::class);

    Route::get('sftps/{sftpServer?}', SftpComponent::class);

    Route::prefix('settings')->group(function () {
        Route::get('', SettingsTagComponent::class);
        Route::get('tags', SettingsTagComponent::class);
        Route::get('users', SettingsUsersComponent::class);
        Route::prefix('nangu')->group(function () {
            Route::get('isps', SettingsIspComponent::class);
            Route::get('isps-channel-packages-to-tags', SettingsTagToChannelPackageComponent::class);
        });
    });
});
