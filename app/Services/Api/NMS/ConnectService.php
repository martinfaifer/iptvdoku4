<?php

namespace App\Services\Api\NMS;

use App\Models\Device;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

/**
 * This class is only for getting informations from nms about device
 */
class ConnectService
{
    protected $endPoints = [
        'search' => 'v2/nms/devices?filter[searcher]=ip:%ip%&includes=all',
    ];


    public function __construct(public Device $device, public string $endPoint)
    {
        //
    }

    public function connect()
    {

        $httpResponse = Http::retry(3, 10000)
            ->withBasicAuth(
                config('services.api.0.nms.username'),
                config('services.api.0.nms.password')
            )
            ->get(config('services.api.0.nms.url') . str_replace("%ip%", $this->device->ip, $this->endPoints[$this->endPoint]));

        if ($httpResponse->ok()) {
            $this->storeData($httpResponse->json());
        }
    }

    public function storeData($httpResponse)
    {
        Cache::add('nms_' . $this->device->id, $httpResponse['data'], 3600);
    }
}
