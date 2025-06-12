<?php

namespace App\Services\Api\NanguTv;

use App\Models\NanguIsp;
use App\Models\GeniusTvChart;
use App\Models\NanguSubscriber;
use App\Models\NanguSubscription;
use App\Actions\Networking\GenerateMacAddressAction;

class NanguSubscriptionsService
{
    public function get(): void
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

    public function getInfo(): void
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

    public function count_subscriptions_per_isp(): void
    {
        foreach (NanguIsp::get() as $nanguIsp) {
            GeniusTvChart::create([
                'item' => 'subscriptions',
                'value' => NanguSubscription::forIsp($nanguIsp->id)->count(),
                'nangu_isp_id' => $nanguIsp->id,
            ]);
        }
    }

    public function create(string|int $subscriberCode, string|int $ispCode): string|int
    {
        $connection = (new ConnectService('subscription'));
        $subscriptionCode = $subscriberCode . rand(1, 10); // give a random number for unique datas

        $connection->connect(
            params: [
                'Create' =>
                [
                    "subscriberCode" => $subscriberCode,
                    "subscriptionCode" => $subscriptionCode,
                    "subscriptionStbAccountCode" => $subscriptionCode,
                    "currencyCode" => config('services.api.iptv_promo.currency'),
                    "tariffCode" => config('services.api.iptv_promo.tarrifCode'),
                    "localityCode" => config('services.api.iptv_promo.locality'),
                    "ispCode" => intval($ispCode)
                ]
            ],
            soap_call_parameter: 'Create'
        );

        return $subscriptionCode;
    }

    public function enable(string|int $subscriptionCode, string|int $ispCode): void
    {
        $connection = (new ConnectService('subscription'));

        $connection->connect(
            params: [
                'Enable' =>
                [
                    "subscriptionCode" => $subscriptionCode,
                    "subscriptionStbAccountCode" => $subscriptionCode,
                    "puk" => (new GenerateMacAddressAction())->execute(),
                    "ispCode" => $ispCode
                ]
            ],
            soap_call_parameter: 'Enable'
        );
    }
}
