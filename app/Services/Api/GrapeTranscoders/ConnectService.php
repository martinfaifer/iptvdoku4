<?php

namespace App\Services\Api\GrapeTranscoders;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ConnectService
{
    public $connection;

    public $endPoints = [
        'transcoders' => [
            'method' => 'get',
            'endpoint' => '/transcoders',
            'formData' => null,
        ],
        'transcoder_status' => [
            'method' => 'post',
            'endpoint' => '/transcoder/status',
            'formData' => [
                'ip' => '%transcoderIp%',
            ],
        ],
        'streams_on_transcoders' => [
            'method' => 'post',
            'endpoint' => '/transcoder/streams',
            'formData' => [
                'transcoderIp' => '%transcoderIp%',
            ],
        ],
        'stop_transcoding_stream' => [
            'method' => 'post',
            'endpoint' => '/transcoder/stream/stop',
            'formData' => null,
        ],
        'start_transcoding_stream' => [
            'method' => 'post',
            'endpoint' => '/transcoder/stream/start',
            'formData' => null,
        ],
    ];

    public function __construct($endpointType, ?array $formData = null, ?string $params = null)
    {
        try {
            if (! is_null($formData)) {
                $this->endPoints[$endpointType]['formData'] = $formData;
            }

            $requestType = match ($this->endPoints[$endpointType]['method']) {
                'get' => 'get',
                'post' => 'post',
                'delete' => 'delete'
            };

            $this->connection = Http::$requestType(
                config('services.api.3.grape_transcoders.url').$this->endPoints[$endpointType]['endpoint'],
                $this->endPoints[$endpointType]['formData']
            );
        } catch (\Throwable $th) {
            $this->connection = null;
        }
    }

    /**
     * cacheKey is used for storing results in to the cache for faster manipulation with data in fe
     */
    public function connect(?string $cacheKey = null)
    {
        // dd($this->connection);
        if (is_null($this->connection)) {
            dd('je null', $this->connection);
        }

        if (! $this->connection->ok()) {
            dd('neni ok', $this->connection);
        }

        if (array_key_exists('data', $this->connection->json())) {
            return $this->connection->json()['data'];
        }

        return $this->connection->json();
    }
}
