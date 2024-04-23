<?php

namespace App\Traits\Devices\GrapeTranscoders;

use App\Services\Api\GrapeTranscoders\ConnectService;

trait GrapeTranscoderChannelTrait
{
    public function pause_transcoding(string|int $pid, object $device)
    {
        $response = (new ConnectService(
            endpointType: 'stop_transcoding_stream',
            formData: [
                'transcoderIp' => $device->ip,
                'streamPid' => $pid,
                'cmd' => "KILL"
            ]
        ))->connect();

        return $response;
    }

    public function start_transcoding(int|string $streamId, object $device)
    {
        $response = (new ConnectService(
            endpointType: 'start_transcoding_stream',
            formData: [
                'transcoderIp' => $device->ip,
                'streamId' => $streamId,
                'cmd' => "START"
            ]
        ))->connect();

        return $response;
    }

    public function streams_on_transcoder(object $device)
    {
        $response = (new ConnectService(
            endpointType: 'streams_on_transcoders',
            formData: [
                'transcoderIp' => $device->ip
            ]
        ))->connect();

        return $response;
    }
}
