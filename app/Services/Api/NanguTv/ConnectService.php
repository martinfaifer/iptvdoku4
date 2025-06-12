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
                    ? new SoapClient(config('services.api.nanguTv.ssl_url') . $this->endPoints[$wsdl], [
                        'stream_context' => $context,
                    ])
                    : [];
            } else {
                $this->soap = (! is_null(config('services.api.nanguTv.url')))
                    ? new SoapClient(config('services.api.nanguTv.url') . $this->endPoints[$wsdl], [
                        'trace' => 1,
                        'exceptions' => true,
                        'connection_timeout' => 10,
                    ])
                    : [];
            }
        } catch (\Throwable $th) {
            $this->soap = [];
            info('error_wsdl_log', [$th]);
        }
    }

    public function connect(array $params, string $soap_call_parameter): mixed
    {
        try {
            $soap_data = $this->soap->__soapCall($soap_call_parameter, $params);
            $response = json_decode(json_encode($soap_data), true);

            info('wsdl_request', $params);
            info('wsdl_response', [$response]);
            return $response;
        } catch (\SoapFault $e) {
            // Specifická chyba od SOAP serveru
            logger()->error('SOAP Fault', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
                'params' => $params,
                'call' => $soap_call_parameter,
            ]);
            return [];
        } catch (\Throwable $th) {
            logger()->error('SOAP error', [
                'message' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            return [];
        }
    }
}
