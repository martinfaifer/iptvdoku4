<?php

namespace App\Services\Api\NanguTv;

use App\Models\NanguSubscriber;
use App\Models\NanguSubscription;

class NanguSubscriptionsService
{
    public function get()
    {
        $connection = (new ConnectService('subscriber'));

        foreach (NanguSubscriber::with('nanguIsp')->get() as $subscriber) {
            $nanguResponse = $connection->connect(
                [
                    'subscriberCode' => [
                        'subscriberCode' => $subscriber->subscriberCode,
                        'ispCode' => $subscriber->nanguIsp->nangu_isp_id,
                    ],
                ],
                'getSubscriptions'
            );

            try {
                if (! empty($nanguResponse)) {

                    if (array_key_exists('subscriptionCode', $nanguResponse['subscriptions'])) {
                        NanguSubscription::create([
                            'nangu_subscriber_id' => $subscriber->id,
                            'subscriptionCode' => $nanguResponse['subscriptions']['subscriptionCode'],
                            'subscriptionState' => $nanguResponse['subscriptions']['subscriptionState'],
                            'nangu_isp_id' => $subscriber->nanguIsp->id,
                        ]);
                    } else {
                        foreach ($nanguResponse['subscriptions'] as $subscription) {
                            NanguSubscription::create([
                                'nangu_subscriber_id' => $subscriber->id,
                                'subscriptionCode' => $subscription['subscriptionCode'],
                                'subscriptionState' => $subscription['subscriptionState'],
                                'nangu_isp_id' => $subscriber->nanguIsp->id,
                            ]);
                        }
                    }
                }
            } catch (\Throwable $th) {
                // dd("chyba", $nanguResponse);
            }
        }
    }

    public function getInfo()
    {
        $connection = (new ConnectService('subscription'));
        $subscriptions = NanguSubscription::with('subscriber.nanguIsp')->get();

        foreach ($subscriptions as $subscription) {
            $nanguResponse = $connection->connect(
                [
                    'subscriptionCode' => [
                        'subscriptionCode' => $subscription->subscriptionCode,
                        'ispCode' => $subscription->subscriber->nanguIsp->nangu_isp_id,
                    ],
                ],
                'getInfo'
            );

            if (
                array_key_exists('tariffCode', $nanguResponse) &&
                array_key_exists('localityCode', $nanguResponse)
            ) {

                (new NanguStbAccountService())->storeFromSubscription(
                    stbAccounts: $nanguResponse['getSubscriptionStbAccountsResponse'],
                    subscriptionId: $subscription->id
                );

                $subscription->update([
                    'tariffCode' => $nanguResponse['tariffCode'],
                    'localityCode' => $nanguResponse['localityCode'],
                    'offers' => NanguHelper::getOffersAsString($nanguResponse['getOffersResponse']),
                ]);
            }
        }
    }
}
