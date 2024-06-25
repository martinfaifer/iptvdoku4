<?php

namespace App\Services\Api\Nimble;

use Illuminate\Support\Facades\Http;

class ConnectService
{
    public array $endpoints = [
        'get_server' => 'server/%server_id%?client_id=%client_id%&api_key=%api_key%',
        'update_server' => [
            'method' => 'PUT',
            'path' => 'server/%server_id%?client_id=%client_id%&api_key=%api_key%'
        ],
        'incoming_streams' => 'server/%server_id%/mpegts/incoming?client_id=%client_id%&api_key=%api_key%',
        'incoming_streams_pause' => 'server/%server_id%/mpegts/incoming/%stream_id%/pause?client_id=%client_id%&api_key=%api_key%',
        'incoming_streams_resume' => 'server/%server_id%/mpegts/incoming/%stream_id%/resume?client_id=%client_id%&api_key=%api_key%',
        'incoming_streams_restart' => 'server/%server_id%/mpegts/incoming/%stream_id%/restart?client_id=%client_id%&api_key=%api_key%',
        'outgoing_streams' => 'server/%server_id%/mpegts/outgoing?client_id=%client_id%&api_key=%api_key%',
        'outgoing_streams_pause' => 'server/%server_id%/mpegts/outgoing/%stream_id%/pause?client_id=%client_id%&api_key=%api_key%',
        'outgoing_streams_resume' => 'server/%server_id%/mpegts/outgoing/%stream_id%/resume?client_id=%client_id%&api_key=%api_key%',
        'outgoing_streams_restart' => 'server/%server_id%/mpegts/outgoing/%stream_id%/restart?client_id=%client_id%&api_key=%api_key%',
    ];

    public function connect(?string $endpoint = null, ?string $serverId = null, ?string $streamId = null): mixed
    {
        if (is_null($endpoint) || is_null($serverId)) {
            $response = Http::timeout(30)
                ->get(config('services.api.2.nimble.url') . 'server?client_id=' . config('services.api.2.nimble.client_id') . '&api_key=' . config('services.api.2.nimble.api_key'));
        } else {
            $response = Http::timeout(30)->get(
                config('services.api.2.nimble.url') . str_replace(['%server_id%', '%stream_id%', '%client_id%', '%api_key%'], [$serverId, $streamId, config('services.api.2.nimble.client_id'), config('services.api.2.nimble.api_key')], $this->endpoints[$endpoint])
            );
            // $response = Http::timeout(30)
            //     ->get(config('services.api.2.nimble.url') .  $serverId . $this->endpoints[$endpoint] . '?client_id=' . config('services.api.2.nimble.client_id') . '&api_key=' . config('services.api.2.nimble.api_key'));
        }

        if ($response->ok()) {
            return $response->json();
        }

        return false;
    }
}
