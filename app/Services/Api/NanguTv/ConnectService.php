<?php

namespace App\Services\Api\NanguTv;

use SoapClient;

class ConnectService
{
    public mixed $soap;

    public array $endPoints = [
        'billing' => '/adminws/billing/BillingEndpoint?wsdl',
        'subscription' => '/adminws/provisioning/SubscriptionEndpoint?wsdl',
        'subscriber' => '/adminws/provisioning/SubscriberEndpoint?wsdl',
        'identity' => '/adminws/provisioning/IdentityEndpoint?wsdl',
        'iptv' => '/adminws/iptv/IptvEndpoint?wsdl',
    ];

    public function __construct(string $wsdl)
    {
        try {
            if (file_exists(public_path(config('services.api.nanguTv.cert'))) && file_exists(public_path(config('services.api.nanguTv.pk')))) {
                $context = stream_context_create([
                    'ssl' => [
                        'local_cert' => public_path(config('services.api.nanguTv.cert')),
                        'local_pk' => public_path(config('services.api.nanguTv.pk')),
                    ],
                ]);

                $this->soap = (! is_null(config('services.api.nanguTv.ssl_url')))
                    ? new SoapClient(config('services.api.nanguTv.ssl_url').$this->endPoints[$wsdl], [
                        'stream_context' => $context,
                    ])
                    : [];
            } else {
                $this->soap = (! is_null(config('services.api.nanguTv.url')))
                    ? new SoapClient(config('services.api.nanguTv.url').$this->endPoints[$wsdl])
                    : [];
            }
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
