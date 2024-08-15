<?php

namespace App\Actions\Tools;

use App\Models\AnalyzeStream;
use App\Services\Api\IptvDohled\ConnectService;

class AnalyzeStreamAction
{
    public function __construct(public string $stream)
    {
        if (!str_contains($stream, ":1234")) {
            $this->stream = $stream . ":1234";
        }
    }

    public function __invoke()
    {
        $connection = (new ConnectService(
            endpointType: "analyze",
            formData: [
                'stream_url' => $this->stream
            ]
        ));

        $response = $connection->connect();

        AnalyzeStream::create([
            'stream_url' => $this->stream,
            'analyze' => $response
        ]);

        return $response;
    }
}
