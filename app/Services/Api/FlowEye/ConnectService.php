<?php

namespace App\Services\Api\FlowEye;

use App\Traits\Api\RequestTypeTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ConnectService
{
    use RequestTypeTrait;

    public $connection;

    public array $endPoints = [
        'procesess' => [
            'method' => "get",
            'endpoint' => "v1/processes",
            'formData' => null
        ],
        'template_procesess' => [
            'method' => "get",
            'endpoint' => "v1/template-processes",
            'formData' => null
        ],
        'user' => [
            'method' => "get",
            'endpoint' => "v1/users/%params%",
            'formData' => null
        ]
    ];

    public function __construct($endpointType, ?array $formData = null, ?string $params = null)
    {
        try {
            if (is_array($formData)) {
                $this->endPoints[$endpointType]['formData'] = $formData;
            }

            if (!is_null($params)) {
                $this->endPoints[$endpointType]['endpoint'] = str_replace('%params%', $params, $this->endPoints[$endpointType]['endpoint']);
            }

            $requestType = $this->get_request_type($this->endPoints[$endpointType]['method']);

            $this->connection = Http::withHeaders([
                'x-api-token' => config('services.api.8.floweye.api_token')
            ])->$requestType(
                config('services.api.8.floweye.url') . $this->endPoints[$endpointType]['endpoint'],
                $this->endPoints[$endpointType]['formData']
            );
        } catch (\Throwable $th) {
            $this->connection = null;
        }
    }

    public function connect(?string $cacheKey = null)
    {
        if (is_null($this->connection)) {
            return [];
        }

        if ($this->connection->ok()) {
            if (!is_null($cacheKey)) {
                Cache::put($cacheKey, $this->connection->json(), 3600);
            }
            return $this->connection->json();
        }

        return [];
    }

    public function get_user()
    {

    }
}
