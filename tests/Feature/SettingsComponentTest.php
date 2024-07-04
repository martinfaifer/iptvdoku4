<?php

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
use App\Livewire\Settings\GeniusTv\Statistics\SettingsGeniusTvStatisticsHboComponent;
use App\Livewire\Settings\Nangu\Isps\SettingsIspComponent;
use App\Livewire\Settings\Nangu\Isps\SettingsTagToChannelPackageComponent;
use App\Livewire\Settings\Notifications\Slack\SettingsSlackNotificationComponent;
use App\Livewire\Settings\Notifications\Weather\SettingsWeatherNotificationComponent;
use App\Livewire\Settings\Tags\SettingsTagComponent;
use App\Livewire\Settings\Users\SettingsUsersComponent;
use App\Models\User;
use App\Models\UserRole;

it('return settings dashboard route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/dashboard')->assertSeeLivewire(SettingsDashboardComponent::class);
});

it('return settings tags route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/tags')->assertSeeLivewire(SettingsTagComponent::class);
});

it('return settings users route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/users')->assertSeeLivewire(SettingsUsersComponent::class);
});

it('return settings nangu isps route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/nangu/isps')->assertSeeLivewire(SettingsIspComponent::class);
});

it('return settings nangu channel packages route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/nangu/isps-channel-packages-to-tags')->assertSeeLivewire(SettingsTagToChannelPackageComponent::class);
});

it('return settings geniustv statistics route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/geniustv/statistics/hbo')->assertSeeLivewire(SettingsGeniusTvStatisticsHboComponent::class);
});

it('return settings geniustv statistics hbo route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/geniustv/statistics/channels')->assertSeeLivewire(SettingsGeniusTvStatisticsChannelsComponent::class);
});

it('return settings geniustv static-taxes route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/geniustv/static-taxes')->assertSeeLivewire(SettingsGeniusTvStaticTaxesComponent::class);
});

it('return settings geniustv channels-taxess route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/geniustv/channels-taxes')->assertSeeLivewire(SettingsGeniusTvChannelsTaxesComponent::class);
});

it('return settings geniustv channel-packages route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/geniustv/channel-packages')->assertSeeLivewire(SettingsGeniusTvChannelPackagesTaxesComponent::class);
});

it('return settings geniustv offer-packages route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/geniustv/offer-taxes')->assertSeeLivewire(SettingsGeniusTvOfferTaxesComponent::class);
});

it('return settings geniustv discounts route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/geniustv/discounts')->assertSeeLivewire(SettingsGeniusTvDiscountsComponent::class);
});

it('return settings geniustv invoices route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/geniustv/invoices')->assertSeeLivewire(SettingsGeniusTvInvoicesComponent::class);
});

it('return settings channels restart route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/channels/restart')->assertSeeLivewire(SettingsChannelsRestartComponent::class);
});

it('return settings channels banners route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/channels/banners')->assertSeeLivewire(SettingsChannelsBannersComponent::class);
});

it('return settings multicats sources route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/channels/multicats/sources')->assertSeeLivewire(SettingsChannelsBannersComponent::class);
});

it('return settings notifications slack route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/notifications/slack')->assertSeeLivewire(SettingsSlackNotificationComponent::class);
});

it('return settings notifications weather route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/notifications/weather')->assertSeeLivewire(SettingsWeatherNotificationComponent::class);
});

it('return settings devices vendors route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/devices/vendors')->assertSeeLivewire(SettingsDevicesVendorsComponent::class);
});

it('return settings devices distributors route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('settings/devices/distributors')->assertSeeLivewire(SettingsDevicesDistributorsComponent::class);
});
