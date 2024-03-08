<?php

namespace App\Services\Api\Nimble;

use Illuminate\Support\Facades\Http;

class ConnectService
{
    public array $endpoints = [
        'incoming_streams' => '/mpegts/incoming',
        'outgoing_streams' => '/mpegts/outgoing',
    ];

    public function connect(?string $endpoint = null, ?string $serverId = null): mixed
    {
        if (is_null($endpoint) || is_null($serverId)) {
            $response = Http::timeout(30)
                ->get(config('services.api.2.nimble.url').'server?client_id='.config('services.api.2.nimble.client_id').'&api_key='.config('services.api.2.nimble.api_key'));
        } else {
            $response = Http::timeout(30)
                ->get(config('services.api.2.nimble.url').'server/'.$serverId.$this->endpoints[$endpoint].'?client_id='.config('services.api.2.nimble.client_id').'&api_key='.config('services.api.2.nimble.api_key'));
        }

        if ($response->ok()) {
            return $response->json();
        }

        return false;
    }
}
