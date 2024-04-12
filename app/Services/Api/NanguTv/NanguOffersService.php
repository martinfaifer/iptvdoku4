<?php

namespace App\Services\Api\NanguTv;

use App\Models\NanguSubscription;
use App\Services\Api\NanguTv\ConnectService;

class NanguOffersService
{
    public function getInfo()
    {
        $connection = (new ConnectService('billing'));
        $subscriptions = NanguSubscription::with('subscriber.nanguIsp')->get();

        foreach ($subscriptions as $subscription) {

            if (!str_contains($subscription->offers, ",")) {
                $nanguResponse = $connection->connect(
                    [
                        'subscriptionCode' => [
                            'offerCode' => $subscription->offers,
                            'ispCode' => $subscription->subscriber->nanguIsp->nangu_isp_id
                        ]
                    ],
                    'getOfferInfo'
                );

                if (array_key_exists('offerChannelPackageCodes', $nanguResponse)) {
                    if (is_array($nanguResponse['offerChannelPackageCodes'])) {
                        $subscription->update([
                            'channelPackagesCodes' => implode(",", $nanguResponse['offerChannelPackageCodes'])
                        ]);
                    } else {
                        $subscription->update([
                            'channelPackagesCodes' => $nanguResponse['offerChannelPackageCodes']
                        ]);
                    }
                }
            }

            if (str_contains($subscription->offers, ",")) {
                $channelPackages = [];
                foreach (explode(",", $subscription->offers) as $offer) {
                    $nanguResponse = $connection->connect(
                        [
                            'subscriptionCode' => [
                                'offerCode' => $offer,
                                'ispCode' => $subscription->subscriber->nanguIsp->nangu_isp_id
                            ]
                        ],
                        'getOfferInfo'
                    );

                    if (array_key_exists('offerChannelPackageCodes', $nanguResponse)) {
                        if (is_string($nanguResponse['offerChannelPackageCodes'])) {
                            array_push($channelPackages, $nanguResponse['offerChannelPackageCodes']);
                        } else {
                            array_push($channelPackages, ...$nanguResponse['offerChannelPackageCodes']);
                        }
                    }
                }
                $subscription->update([
                    'channelPackagesCodes' => implode(",", array_unique($channelPackages))
                ]);
            }
        }
    }
}
