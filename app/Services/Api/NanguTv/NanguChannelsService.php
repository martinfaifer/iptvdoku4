<?php

namespace App\Services\Api\NanguTv;

use App\Models\Channel;
use App\Models\GeniusTvChart;
use App\Models\NanguIsp;
use App\Models\NanguSubscription;

class NanguChannelsService
{
    public function get_channels_by_channels_packages_code()
    {
        $connection = (new ConnectService('billing'));
        $subscriptions = NanguSubscription::with('subscriber.nanguIsp')->get();

        foreach ($subscriptions as $subscription) {
            // single package
            if (!str_contains($subscription->channelPackagesCodes, ",")) {
                $nanguResponse = $connection->connect(
                    [
                        'getChannelPackageInfo' => [
                            'channelPackageCode' => $subscription->channelPackagesCodes,
                            'ispCode' => $subscription->subscriber->nanguIsp->nangu_isp_id
                        ]
                    ],
                    'getChannelPackageInfo'
                );

                if (array_key_exists('channelKeys', $nanguResponse)) {
                    if (!empty($nanguResponse['channelKeys'])) {
                        if (is_string($nanguResponse['channelKeys'])) {
                            $subscription->update([
                                'channels' => $nanguResponse['channelKeys']
                            ]);
                        }
                    }

                    if (is_array($nanguResponse['channelKeys'])) {
                        $subscription->update([
                            'channels' => implode(",", array_unique($nanguResponse['channelKeys']))
                        ]);
                    }
                }
            }

            // multiple packages
            $channels = [];
            if (str_contains($subscription->channelPackagesCodes, ",")) {
                foreach (explode(",", $subscription->channelPackagesCodes) as $channelPackage) {
                    if ($channelPackage != "PROMO") {
                        $nanguResponse = $connection->connect(
                            [
                                'getChannelPackageInfo' => [
                                    'channelPackageCode' => $channelPackage,
                                    'ispCode' => $subscription->subscriber->nanguIsp->nangu_isp_id
                                ]
                            ],
                            'getChannelPackageInfo'
                        );

                        if (array_key_exists('channelKeys', $nanguResponse)) {
                            if (!empty($nanguResponse['channelKeys'])) {
                                if (is_string($nanguResponse['channelKeys'])) {
                                    array_push($channels, $nanguResponse['channelKeys']);
                                }

                                if (is_array($nanguResponse['channelKeys'])) {
                                    array_push($channels, ...$nanguResponse['channelKeys']);
                                }
                            }
                        }
                    }
                }
            }

            if (!empty($channels)) {
                $subscription->update([
                    'channels' => implode(",", array_unique($channels))
                ]);
            }
        }
    }

    public function count_channels_usage_per_isp()
    {
        $nanguIsps = NanguIsp::get();
        $channels = Channel::withNanguChannelCode()->get(['id', 'name', 'nangu_channel_code']);

        foreach ($channels as $channel) {
            // count channel->nangu_channel_code exists in subscriptions with status billing
            if (!is_null($channel->nangu_channel_code)) {
                foreach ($nanguIsps as $nanguIsp) {
                    GeniusTvChart::create([
                        'item' => "channel:$channel->id",
                        'value' => NanguSubscription::forIsp($nanguIsp->id)->isBilling()->hasChannel($channel->nangu_channel_code)->count(),
                        'nangu_isp_id' => $nanguIsp->id
                    ]);
                }
            }
        }
    }

    public function count_channels_usage_total()
    {
        $channels = Channel::withNanguChannelCode()->get(['id', 'name', 'nangu_channel_code']);

        foreach ($channels as $channel) {
            if (!is_null($channel->nangu_channel_code)) {
                GeniusTvChart::create([
                    'item' => "channel:$channel->id",
                    'value' => NanguSubscription::isBilling()->hasChannel($channel->nangu_channel_code)->count()
                ]);
            }
        }
    }
}
