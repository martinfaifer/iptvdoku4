<?php

use App\Livewire\Auth\Login;
use App\Livewire\User\UserComponent;
use App\Livewire\Wiki\WikiComponent;
use Illuminate\Support\Facades\Route;
use App\Livewire\Iptv\Sftps\SftpComponent;
use App\Livewire\Iptv\Channels\IptvChannel;
use App\Livewire\User\UserActionsComponent;
use App\Livewire\Iptv\Devices\DeviceComponent;
use App\Livewire\Iptv\FlowEye\FlowEyeComponent;
use App\Livewire\User\UserNotificationComponent;
use App\Livewire\Auth\ForgottenPasswordComponent;
use App\Livewire\Iptv\Calendar\CalendarComponent;
use App\Livewire\Iptv\Cards\SatelitCardComponent;
use App\Livewire\Iptv\Channels\Notification\ChannelNotificationComponent;
use App\Livewire\Settings\Logs\SettingsLogComponent;
use App\Livewire\Settings\Tags\SettingsTagComponent;
use App\Livewire\Settings\Users\SettingsUsersComponent;
use App\Livewire\IptvMonitoring\IptvMonitoringComponent;
use App\Livewire\Settings\Nangu\Isps\SettingsIspComponent;
use App\Livewire\Nangu\IpPrefixes\NanguIpPrefixesComponent;
use App\Livewire\Settings\Geniustv\TvChannelPackagesComponent;
use App\Livewire\Settings\Dashboard\SettingsDashboardComponent;
use App\Livewire\Settings\Channels\Multicasts\MulticastsSourcesComponent;
use App\Livewire\Settings\Devices\Vendors\SettingsDevicesVendorsComponent;
use App\Livewire\Settings\Nangu\Isps\SettingsTagToChannelPackageComponent;
use App\Livewire\Settings\Channels\Banners\SettingsChannelsBannersComponent;
use App\Livewire\Settings\Channels\Restart\SettingsChannelsRestartComponent;
use App\Livewire\Settings\Geniustv\Invoices\SettingsGeniusTvInvoicesComponent;
use App\Livewire\Settings\Geniustv\Discounts\SettingsGeniusTvDiscountsComponent;
use App\Livewire\Settings\Notifications\Slack\SettingsSlackNotificationComponent;
use App\Livewire\Settings\Geniustv\OfferTaxes\SettingsGeniusTvOfferTaxesComponent;
use App\Livewire\Settings\Devices\Distributors\SettingsDevicesDistributorsComponent;
use App\Livewire\Settings\Geniustv\StaticTaxes\SettingsGeniusTvStaticTaxesComponent;
use App\Livewire\Settings\Geniustv\Statistics\SettingsGeniusTvStatisticsHboComponent;
use App\Livewire\Settings\Notifications\Weather\SettingsWeatherNotificationComponent;
use App\Livewire\Settings\Geniustv\ChannelsTaxes\SettingsGeniusTvChannelsTaxesComponent;
use App\Livewire\Settings\Geniustv\Statistics\SettingsGeniusTvStatisticsChannelsComponent;
use App\Livewire\Settings\Geniustv\ChannelPackagesTaxes\SettingsGeniusTvChannelPackagesTaxesComponent;

Route::get('test', function () {
    return view('pdfs.invoice');
});

Route::get('login', Login::class)->name('login');
Route::get('forgotten-password', ForgottenPasswordComponent::class);

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
    Route::get('prefixes/{ipPrefix?}', NanguIpPrefixesComponent::class);
    Route::get('floweye/{issue?}', FlowEyeComponent::class)->middleware('can:show_tickets, App\Models\User');
    Route::get('iptv-monitoring', IptvMonitoringComponent::class)->middleware('can:show_iptv_monitoring, App\Models\User');
    Route::get('notifications/channels/{ip}', ChannelNotificationComponent::class)->middleware(['can:view,App\Models\Channel']);

    Route::prefix('profile')->group(function () {
        Route::get('', UserComponent::class);
        Route::get('notifications', UserNotificationComponent::class);
        Route::get('actions', UserActionsComponent::class);
    });

    Route::prefix('settings')->group(function () {
        Route::get('dashboard', SettingsDashboardComponent::class)->middleware('can:show_settings_dashboard,App\Models\User');
        Route::get('tags', SettingsTagComponent::class)->middleware('can:show_settings_tags,App\Models\User');
        Route::get('users', SettingsUsersComponent::class)->middleware('can:show_settings_users,App\Models\User');
        Route::get('logs', SettingsLogComponent::class)->middleware('can:show_settings_logs,App\Models\User');
        Route::prefix('nangu')->group(function () {
            Route::get('isps', SettingsIspComponent::class)->middleware('can:show_settings_nangu,App\Models\User');
            Route::get('isps-channel-packages-to-tags', SettingsTagToChannelPackageComponent::class)->middleware('can:show_settings_nangu,App\Models\User');
        });
        Route::prefix('geniustv')->group(function () {
            Route::get('tv-channel-packages', TvChannelPackagesComponent::class);
            Route::prefix('statistics')->group(function () {
                Route::get('hbo', SettingsGeniusTvStatisticsHboComponent::class)->middleware('can:show_settings_geniustv,App\Models\User');
                Route::get('channels', SettingsGeniusTvStatisticsChannelsComponent::class)->middleware('can:show_settings_geniustv,App\Models\User');
            });
            Route::get('static-taxes', SettingsGeniusTvStaticTaxesComponent::class)->middleware('can:show_settings_geniustv,App\Models\User');
            Route::get('channels-taxes', SettingsGeniusTvChannelsTaxesComponent::class)->middleware('can:show_settings_geniustv,App\Models\User');
            Route::get('channel-packages', SettingsGeniusTvChannelPackagesTaxesComponent::class)->middleware('can:show_settings_geniustv,App\Models\User');
            Route::get('offer-taxes', SettingsGeniusTvOfferTaxesComponent::class)->middleware('can:show_settings_geniustv,App\Models\User');
            Route::get('discounts', SettingsGeniusTvDiscountsComponent::class)->middleware('can:show_settings_geniustv,App\Models\User');
            Route::get('invoices', SettingsGeniusTvInvoicesComponent::class)->middleware('can:show_settings_geniustv,App\Models\User');
        });

        Route::prefix('channels')->group(function () {
            Route::get('restart', SettingsChannelsRestartComponent::class)->middleware('can:show_settings_channels_restart,App\Models\User');
            Route::get('banners', SettingsChannelsBannersComponent::class)->middleware('can:show_settings_channels_banners,App\Models\User');
            Route::get('multicats/sources', MulticastsSourcesComponent::class)->middleware('can:show_settings_channels_multicast_sources,App\Models\User');
        });

        Route::prefix('notifications')->group(function () {
            Route::get('slack', SettingsSlackNotificationComponent::class)->middleware('can:show_settings_notifications,App\Models\User');
            Route::get('weather', SettingsWeatherNotificationComponent::class)->middleware('can:show_settings_notifications,App\Models\User');
        });

        Route::prefix('devices')->group(function () {
            Route::get('vendors', SettingsDevicesVendorsComponent::class)->middleware('can:show_settings_devices,App\Models\User');
            Route::get('distributors', SettingsDevicesDistributorsComponent::class)->middleware('can:show_settings_devices,App\Models\User');
        });
    });
});
