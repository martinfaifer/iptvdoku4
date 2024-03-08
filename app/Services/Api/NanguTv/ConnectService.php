<?php

namespace App\Services\Api\NanguTv;

use SoapClient;

class ConnectService
{
    public $soap;

    public $endPoints = [
        'billing' => '/adminws/billing/BillingEndpoint?wsdl',
        'subscription' => '/adminws/provisioning/SubscriptionEndpoint?wsdl',
        'subscriber' => '/adminws/provisioning/SubscriberEndpoint?wsdl',
        'identity' => '/adminws/provisioning/IdentityEndpoint?wsdl',
        'iptv' => '/adminws/iptv/IptvEndpoint?wsdl',
    ];

    public function __construct(string $wsdl)
    {
        try {
            $this->soap = (! is_null(config('services.api.nanguTv.url')))
                ? new SoapClient(config('services.api.nanguTv.url').$this->endPoints[$wsdl])
                : [];
        } catch (\Throwable $th) {
            $this->soap = [];
        }
    }

    public function connect(array $params, string $soap_call_parameter): mixed
    {
        try {
            $soap_data = $this->soap->__soapCall($soap_call_parameter, $params);
            $response = json_decode(json_encode($soap_data), true);

            return $response;
        } catch (\Throwable $th) {
            return [];
        }
    }
}
