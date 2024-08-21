<?php

namespace App\Services\Api\NanguTv;

class ChannelPackagesService
{
    public function get_channel_packages(string $nangu_isp_id): mixed
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

    public function store(string $channel_package_code, string $nangu_channel_code, string|int $nangu_isp_id): mixed
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

    public function delete(string $channel_package_code, string $nangu_channel_code, int|string $nangu_isp_id): mixed
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
