<?php

use App\Livewire\Auth\Login;

use App\Livewire\Wiki\WikiComponent;
use Illuminate\Support\Facades\Route;
use App\Livewire\Iptv\Sftps\SftpComponent;
use App\Livewire\Iptv\Channels\IptvChannel;
use App\Livewire\Iptv\Devices\DeviceComponent;
use App\Livewire\Iptv\Calendar\CalendarComponent;
use App\Livewire\Iptv\Cards\SatelitCardComponent;
use App\Livewire\Settings\Tags\SettingsTagComponent;
use App\Livewire\Settings\Users\SettingsUsersComponent;
use App\Livewire\Settings\Nangu\Isps\SettingsIspComponent;
use App\Livewire\Settings\Nangu\Isps\SettingsTagToChannelPackageComponent;
use App\Livewire\Settings\Geniustv\Discounts\SettingsGeniusTvDiscountsComponent;
use App\Livewire\Settings\Geniustv\OfferTaxes\SettingsGeniusTvOfferTaxesComponent;
use App\Livewire\Settings\Geniustv\StaticTaxes\SettingsGeniusTvStaticTaxesComponent;
use App\Livewire\Settings\GeniusTv\Statistics\SettingsGeniusTvStatisticsHboComponent;
use App\Livewire\Settings\Geniustv\ChannelsTaxes\SettingsGeniusTvChannelsTaxesComponent;
use App\Livewire\Settings\GeniusTv\Statistics\SettingsGeniusTvStatisticsChannelsComponent;
use App\Livewire\Settings\Geniustv\ChannelPackagesTaxes\SettingsGeniusTvChannelPackagesTaxesComponent;
use App\Livewire\Settings\GeniusTv\Invoices\SettingsGeniusTvInvoicesComponent;

Route::get('test', function () {
    return view('pdfs.invoice');
});

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

    Route::get('wiki/{topic?}', WikiComponent::class);

    Route::prefix('settings')->group(function () {
        Route::get('', SettingsTagComponent::class);
        Route::get('tags', SettingsTagComponent::class);
        Route::get('users', SettingsUsersComponent::class);
        Route::prefix('nangu')->group(function () {
            Route::get('isps', SettingsIspComponent::class);
            Route::get('isps-channel-packages-to-tags', SettingsTagToChannelPackageComponent::class);
        });
        Route::prefix('geniustv')->group(function () {
            Route::prefix('statistics')->group(function () {
                Route::get('hbo', SettingsGeniusTvStatisticsHboComponent::class);
                Route::get('channels', SettingsGeniusTvStatisticsChannelsComponent::class);
            });
            Route::get('static-taxes', SettingsGeniusTvStaticTaxesComponent::class);
            Route::get('channels-taxes', SettingsGeniusTvChannelsTaxesComponent::class);
            Route::get('channel-packages', SettingsGeniusTvChannelPackagesTaxesComponent::class);
            Route::get('offer-taxes', SettingsGeniusTvOfferTaxesComponent::class);
            Route::get('discounts', SettingsGeniusTvDiscountsComponent::class);
            Route::get('invoices', SettingsGeniusTvInvoicesComponent::class);
        });
    });
});
