<?php

namespace App\Observers;

use App\Jobs\LogJob;
use App\Models\Alert;
use App\Models\Chart;
use App\Models\Loger;
use App\Models\Device;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Jobs\SendEmailNotificationJob;
use App\Traits\Devices\CacheDevicesTrait;
use App\Jobs\SearchIfSatCardIsUsedInDeviceJob;

class DeviceObserver
{
    use CacheDevicesTrait;
    public function created(Device $device)
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
                'template' => $device->template,
                'showed_create_template' => $device->showed_create_template,
                'has_channels' => $device->has_channels,
            ])
        );

        SendEmailNotificationJob::dispatch(
            "Bylo přidáno zařízení " . $device->name,
            "Uživatel " . Auth::user()->email . " přidal zařízení " . $device->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );

        // cache devices menu
        $this->cache_devices_for_menu();
    }

    public function updated(Device $device)
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
                    'template' => $device->template,
                    'showed_create_template' => $device->showed_create_template,
                    'has_channels' => $device->has_channels,
                ])
            );

            SendEmailNotificationJob::dispatch(
                "Bylo upraveno zařízení " . $device->name,
                "Uživatel " . Auth::user()->email . " upravil zařízení " . $device->name,
                Auth::user()->email,
                'notify_if_channel_change'
            );
        }

        // search for sat card
        SearchIfSatCardIsUsedInDeviceJob::dispatch();

        // cache devices menu
        $this->cache_devices_for_menu();
    }

    public function deleted(Device $device)
    {
        // delete charts
        Chart::where('item', 'like', '%device:' . $device->id . ':%')->delete();
        // delete alerts
        Alert::where('type', 'gpu_check_failed')->where('item_id', $device->id)->delete();
        Alert::where('type', 'gpu_problem')->where('item_id', $device->id)->delete();
        // delete device contacts
        Contact::where('type', 'device')->where('item_id', $device->id)->delete();

        SearchIfSatCardIsUsedInDeviceJob::dispatch();

        // cache devices menu
        $this->cache_devices_for_menu();

        SendEmailNotificationJob::dispatch(
            "Bylo odebráno zařízení " . $device->name,
            "Uživatel " . Auth::user()->email . " oderbal zařízení " . $device->name,
            Auth::user()->email,
            'notify_if_channel_change'
        );
    }
}
