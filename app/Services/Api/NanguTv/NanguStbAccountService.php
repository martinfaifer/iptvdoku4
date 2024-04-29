<?php

namespace App\Services\Api\NanguTv;

use App\Models\NanguStbAccountCode;

class NanguStbAccountService
{
    public function storeFromSubscription(array $stbAccounts, int $subscriptionId): void
    {
        try {

            if (! empty($stbAccounts)) {
                if (array_key_exists('subscriptionStbAccountCode', $stbAccounts['subscriptionStbAccounts'])) {
                    NanguStbAccountCode::create([
                        'nangu_subscription_code_id' => $subscriptionId,
                        'stbAccountCodes' => $stbAccounts['subscriptionStbAccounts']['subscriptionStbAccountCode'],
                    ]);
                } else {
                    foreach ($stbAccounts['subscriptionStbAccounts'] as $stbAccount) {
                        NanguStbAccountCode::create([
                            'nangu_subscription_code_id' => $subscriptionId,
                            'stbAccountCodes' => $stbAccount['subscriptionStbAccountCode'],
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            dd($stbAccounts);
        }
    }
}
