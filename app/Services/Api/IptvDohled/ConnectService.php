<?php

namespace App\Services\Api\IptvDohled;

use App\Events\BroadcastIptvDohledAlertsEvent;
use App\Traits\Api\RequestTypeTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ConnectService
{
    use RequestTypeTrait;

    public $connection;

    public $endPoints = [
        'alerts' => [
            'method' => 'get',
            'endpoint' => '/api/v2/stream/alerts',
            'formData' => null,
        ],
        'get-stream-by-ip' => [
            'method' => 'get',
            'endpoint' => '/api/v2/stream/by-ip/%params%',
            'formData' => null,
        ],
        'store-stream' => [
            'method' => 'post',
            'endpoint' => '/api/v2/stream',
            'formData' => null,
        ],
        'delete-stream' => [
            'method' => 'delete',
            'endpoint' => '/api/v2/stream/%params%',
            'formData' => null,
        ],
    ];

    public function __construct($endpointType, ?array $formData = null, ?string $params = null)
    {
        // try {
        if (is_array($formData)) {
            $this->endPoints[$endpointType]['formData'] = $formData;
        }

        if (!is_null($params)) {
            $this->endPoints[$endpointType]['endpoint'] = str_replace('%params%', $params, $this->endPoints[$endpointType]['endpoint']);
        }

        $requestType = $this->get_request_type($this->endPoints[$endpointType]['method']);

        $this->connection = Http::withBasicAuth(
            config('services.api.iptvDohled.username'),
            config('services.api.iptvDohled.password')
        )->$requestType(
            config('services.api.iptvDohled.url') . $this->endPoints[$endpointType]['endpoint'],
            $this->endPoints[$endpointType]['formData']
        );
        // } catch (\Throwable $th) {
        //     $this->connection = null;
        // }
    }

    public function connect(?string $cacheKey = null)
    {
        $response = $this->connection;
        // info('odpoved primo z fn', [$this->connection]);
        if (is_null($response)) {
            if (!is_null($cacheKey)) {
                Cache::put($cacheKey, [], 3600);
            } else {
                return [];
            }
        } else {
            if ($response->ok()) {
                if (!is_null($cacheKey)) {
                    Cache::put($cacheKey, $response->json(), 3600);
                }
            }
        }

        try {
            return $response->json();
        } catch (\Throwable $th) {
            return [];
        }

        // dispatch event
        BroadcastIptvDohledAlertsEvent::dispatch();
    }
}
