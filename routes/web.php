<?php

use App\Livewire\Auth\Login;
use App\Livewire\Iptv\Calendar\CalendarComponent;
use App\Livewire\Iptv\Cards\SatelitCardComponent;
use App\Livewire\Iptv\Channels\IptvChannel;
use App\Livewire\Iptv\Devices\DeviceComponent;
use App\Livewire\Iptv\FlowEye\FlowEyeComponent;
use App\Livewire\Iptv\Sftps\SftpComponent;
use App\Livewire\Settings\Channels\Banners\SettingsChannelsBannersComponent;
use App\Livewire\Settings\Channels\Restart\SettingsChannelsRestartComponent;
use App\Livewire\Settings\Dashboard\SettingsDashboardComponent;
use App\Livewire\Settings\Devices\Distributors\SettingsDevicesDistributorsComponent;
use App\Livewire\Settings\Devices\Vendors\SettingsDevicesVendorsComponent;
use App\Livewire\Settings\Geniustv\ChannelPackagesTaxes\SettingsGeniusTvChannelPackagesTaxesComponent;
use App\Livewire\Settings\Geniustv\ChannelsTaxes\SettingsGeniusTvChannelsTaxesComponent;
use App\Livewire\Settings\Geniustv\Discounts\SettingsGeniusTvDiscountsComponent;
use App\Livewire\Settings\Geniustv\Invoices\SettingsGeniusTvInvoicesComponent;
use App\Livewire\Settings\Geniustv\OfferTaxes\SettingsGeniusTvOfferTaxesComponent;
use App\Livewire\Settings\Geniustv\StaticTaxes\SettingsGeniusTvStaticTaxesComponent;
use App\Livewire\Settings\Geniustv\Statistics\SettingsGeniusTvStatisticsChannelsComponent;
use App\Livewire\Settings\Geniustv\Statistics\SettingsGeniusTvStatisticsHboComponent;
use App\Livewire\Settings\Nangu\Isps\SettingsIspComponent;
use App\Livewire\Settings\Nangu\Isps\SettingsTagToChannelPackageComponent;
use App\Livewire\Settings\Notifications\Slack\SettingsSlackNotificationComponent;
use App\Livewire\Settings\Notifications\Weather\SettingsWeatherNotificationComponent;
use App\Livewire\Settings\Tags\SettingsTagComponent;
use App\Livewire\Settings\Users\SettingsUsersComponent;
use App\Livewire\Wiki\WikiComponent;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    return view('pdfs.invoice');
});

Route::get('login', Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', IptvChannel::class);
    Route::prefix('channels/{channel?}/{channelType?}')->middleware(['can:view,App\Models\Channel'])->group(function () {
        Route::get('', IptvChannel::class);
    });

    Route::get('devices/{device?}/{component?}', DeviceComponent::class)->middleware('can:view_devices,App\Models\Device');
    Route::get('sat-cards/{satelitCard?}', SatelitCardComponent::class)->middleware('can:view_cards,App\Models\SatelitCard');
    Route::get('calendar', CalendarComponent::class)->middleware('can:show_events,App\Models\Event');
    Route::get('sftps/{sftpServer?}', SftpComponent::class)->middleware('can:show_servers,App\Models\SftpServer');
    Route::get('wiki/{topic?}', WikiComponent::class)->middleware('can:show_topics, App\Models\WikiTopic');

    Route::get('floweye/{issue?}', FlowEyeComponent::class);

    Route::prefix('settings')->group(function () {
        Route::get('', SettingsTagComponent::class);
        Route::get('dashboard', SettingsDashboardComponent::class);
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

        Route::prefix('channels')->group(function () {
            Route::get('restart', SettingsChannelsRestartComponent::class);
            Route::get('banners', SettingsChannelsBannersComponent::class);
        });

        Route::prefix('notifications')->group(function () {
            Route::get('slack', SettingsSlackNotificationComponent::class);
            Route::get('weather', SettingsWeatherNotificationComponent::class);
        });

        Route::prefix('devices')->group(function () {
            Route::get('vendors', SettingsDevicesVendorsComponent::class);
            Route::get('distributors', SettingsDevicesDistributorsComponent::class);
        });
    });
});
