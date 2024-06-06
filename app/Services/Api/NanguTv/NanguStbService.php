<?php

namespace App\Services\Api\NanguTv;

use App\Models\NanguIsp;
use App\Models\NanguStb;
use App\Models\NanguStbAccountCode;
use App\Models\NanguSubscription;

class NanguStbService
{
    public function get_stbs()
    {
        $connection = (new ConnectService('subscription'));
        $stbAccountCodes = NanguStbAccountCode::with('subscriptionCode')->get();

        foreach ($stbAccountCodes as $stbAccountCode) {
            $nanguResponse = $connection->connect(
                [
                    'subscriptionCode' => [
                        'subscriptionCode' => $stbAccountCode->subscriptionCode->subscriptionCode,
                        'subscriptionStbAccountCode' => $stbAccountCode->stbAccountCodes,
                        'ispCode' => $stbAccountCode->subscriptionCode->nanguIsp->nangu_isp_id,
                    ],
                ],
                'getStbInfo'
            );

            if (array_key_exists('stb', $nanguResponse)) {
                NanguStb::create([
                    'nangu_stb_accountCode_id' => $stbAccountCode->id,
                    'stb' => $nanguResponse['stb']['modelCode'],
                ]);
            }
        }
    }

    public function count_stbs_model_per_isp()
    {
        foreach (NanguIsp::get() as $nanguIsp) {
            $subscriptionsWithStbs = NanguSubscription::forIsp($nanguIsp->id)
                ->with('accountCodes.stbs')
                ->get();

            if (! $subscriptionsWithStbs->isEmpty()) {
                foreach ($subscriptionsWithStbs as $subscriptionWithStbs) {
                    foreach ($subscriptionWithStbs->accountCodes as $accountCode) {
                        //
                    }
                }
            }
        }
    }
}
