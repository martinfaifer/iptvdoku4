<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Jobs\SearchIfSatCardIsUsedInDeviceJob;
use App\Jobs\SendEmailNotificationJob;
use App\Models\Alert;
use App\Models\Chart;
use App\Models\Contact;
use App\Models\Device;
use App\Models\Loger;
use App\Traits\Devices\CacheDevicesTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DeviceObserver
{
    use CacheDevicesTrait;

    public function created(Device $device): void
    {
        LogJob::dispatch(
            user: Auth::user()->email,
            type: Loger::CREATED_TYPE,
            item: "device:$device->id",
            payload: json_encode([
                'id' => $device->id,
                'name' => $device->name,
                'device_category_id' => $device->device_category_id,
                'device_vendor_id' => $device->device_vendor_id,
                'ip' => $device->ip,
                'controller_ip' => $device->controller_ip,
                'username' => $device->username,
                'password' => $device->password,
                'is_snmp' => $device->is_snmp,
                'snmp_version' => $device->snmp_version,
                'snmp_private_comunity' => $device->snmp_private_comunity,
                'snmp_public_comunity' => $device->snmp_public_comunity,
                'template' => $device->template, // @phpstan-ignore-line
                'showed_create_template' => $device->showed_create_template,
                'has_channels' => $device->has_channels,
            ])
        );

        SendEmailNotificationJob::dispatch(
            'Bylo přidáno zařízení '.$device->name,
            'Uživatel '.Auth::user()->email.' přidal zařízení '.$device->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );

        // cache devices menu
        $this->cache_devices_for_menu();
    }

    public function updated(Device $device): void
    {
        if (Auth::user()) {
            LogJob::dispatch(
                user: Auth::user()->email,
                type: Loger::UPDATED_TYPE,
                item: "device:$device->id",
                payload: json_encode([
                    'id' => $device->id,
                    'name' => $device->name,
                    'device_category_id' => $device->device_category_id,
                    'device_vendor_id' => $device->device_vendor_id,
                    'ip' => $device->ip,
                    'controller_ip' => $device->controller_ip,
                    'username' => $device->username,
                    'password' => $device->password,
                    'is_snmp' => $device->is_snmp,
                    'snmp_version' => $device->snmp_version,
                    'snmp_private_comunity' => $device->snmp_private_comunity,
                    'snmp_public_comunity' => $device->snmp_public_comunity,
                    'template' => $device->template, // @phpstan-ignore-line
                    'showed_create_template' => $device->showed_create_template,
                    'has_channels' => $device->has_channels,
                ])
            );

            SendEmailNotificationJob::dispatch(
                'Bylo upraveno zařízení '.$device->name,
                'Uživatel '.Auth::user()->email.' upravil zařízení '.$device->name,
                Auth::user()->email,
                'notify_if_channel_change'
            );
        }

        // search for sat card
        SearchIfSatCardIsUsedInDeviceJob::dispatch();

        // cache devices menu
        $this->cache_devices_for_menu();
    }

    public function deleted(Device $device): void
    {
        $this->cache_devices_for_menu();
        SendEmailNotificationJob::dispatch(
            'Bylo odebráno zařízení '.$device->name,
            'Uživatel '.Auth::user()->email.' oderbal zařízení '.$device->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }
}
