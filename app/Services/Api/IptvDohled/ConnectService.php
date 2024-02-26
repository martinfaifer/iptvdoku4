<?php

namespace App\Services\Api\IptvDohled;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ConnectService
{
    public $connection;

    public $endPoints = [
        'alerts' => [
            'method' => 'get',
            'endpoint' => '/api/v2/stream/alerts',
            'formData' => null
        ],
    ];


    public function __construct($endpointType, null|array $formData = null)
    {
        try {
            if (is_array($formData)) {
                $this->endPoints[$endpointType]['formData'] = $formData;
            }
            $requestType = match ($this->endPoints[$endpointType]['method']) {
                'get' => "get",
                'post' => "post",
                'delete' => "delete"
            };

            $this->connection = Http::withBasicAuth(
                config('services.api.iptvDohled.username'),
                config('services.api.iptvDohled.password')
            )->$requestType(
                config('services.api.iptvDohled.url') . $this->endPoints[$endpointType]['endpoint'],
                $this->endPoints[$endpointType]['formData']
            );
        } catch (\Throwable $th) {
            $this->connection = null;
        }
    }

    public function connect(string|null $cacheKey = null)
    {
        $response = $this->connection;
        if (is_null($response)) {
            if (!is_null($cacheKey)) {
                Cache::put($cacheKey, []);
            } else {
                return [];
            }
        } else {
            if ($response->ok()) {
                if (!is_null($cacheKey)) {
                    Cache::put($cacheKey, $response->json());
                } else {
                    return $response->json();
                }
            }
        }
    }
}
