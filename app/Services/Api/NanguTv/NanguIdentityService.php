<?php

namespace App\Services\Api\NanguTv;

class NanguIdentityService
{
    public function create(string $subscriberCode, string|int $ispCode): string|int
    {
        $connection = (new ConnectService('identity'));

        $identity = $connection->connect(
            params: [
                'Create' =>
                [
                    "master" => true,
                    "username" => $subscriberCode,
                    "password" => $subscriberCode,
                    "pairingPin" => mt_rand(1000000000, 9999999999),
                    "ispCode" => $ispCode
                ]
            ],
            soap_call_parameter: 'Create'
        );

        return $identity['identityId'];
    }

    public function assign(string|int $subscriptionStbAccountCode, string|int $identityId, string|int $ispCode)
    {
        $connection = (new ConnectService('subscription'));

        $connection->connect(
            params: [
                'AssignIdentity' =>
                [
                    "subscriptionStbAccountCode" => $subscriptionStbAccountCode,
                    "identityId" => $identityId,
                    "ispCode" => $ispCode
                ]
            ],
            soap_call_parameter: 'AssignIdentity'
        );
    }
}
