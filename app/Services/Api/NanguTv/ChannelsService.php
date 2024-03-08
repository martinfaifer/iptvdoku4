<?php

namespace App\Services\Api\NanguTv;

class ChannelsService
{
    public function detail(?string $nangu_channel_code)
    {
        if (is_null($nangu_channel_code)) {
            return [];
        }

        if (is_null(config('services.api.nanguTv.url'))) {
            return [];
        }

        return (new ConnectService('iptv'))->connect(
            ['getChannelDetail' => ['channelKey' => $nangu_channel_code, 'ispCode' => config('services.api.nanguTv.isp_code')]],
            'getChannelDetail'
        );
    }
}
