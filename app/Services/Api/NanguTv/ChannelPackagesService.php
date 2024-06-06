<?php

namespace App\Services\Api\NanguTv;

class ChannelPackagesService
{
    public function get_channel_packages(string $nangu_isp_id)
    {
        if (is_null(config('services.api.nanguTv.url'))) {
            return [];
        }

        return (new ConnectService('billing'))->connect(
            ['getChannelPackages' => [
                'ispCode' => $nangu_isp_id,
            ]],
            'getChannelPackages'
        );
    }

    public function store($channel_package_code, $nangu_channel_code, $nangu_isp_id)
    {
        if (is_null(config('services.api.nanguTv.url'))) {
            return [];
        }

        return (new ConnectService('billing'))->connect(
            ['addChannelPackageChannel' => [
                'channelPackageCode' => $channel_package_code,
                'channelKey' => $nangu_channel_code,
                'ispCode' => $nangu_isp_id,
            ]],
            'addChannelPackageChannel'
        );
    }

    public function delete($channel_package_code, $nangu_channel_code, $nangu_isp_id)
    {
        if (is_null(config('services.api.nanguTv.url'))) {
            return [];
        }

        return (new ConnectService('billing'))->connect(
            ['removeChannelPackageChannel' => [
                'channelPackageCode' => $channel_package_code,
                'channelKey' => $nangu_channel_code,
                'ispCode' => $nangu_isp_id,
            ]],
            'removeChannelPackageChannel'
        );
    }
}
