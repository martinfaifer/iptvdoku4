<?php

namespace App\Http\Resources;

use App\Models\Channel;
use App\Services\Api\Epg\EpgConnectService;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiEpgResource extends JsonResource
{
    use ApiResponseTrait;

    /**
     * Transform the resource into an array.
     * $request['channel'] is the channel name
     * $request['forDay'] is for day which contains epg data
     */
    public function toArray(Request $request)
    {
        $channel = Channel::where('name', $request['channel'])->first();
        if (! $channel) {
            return $this->not_found_response();
        }

        if (is_null($channel->epg_id)) {
            return $this->not_found_response();
        }

        return $this->succes_response(data: (new EpgConnectService())
            ->get_channel_epg(
                $channel->epg_id,
                $request['forDay'],
                $request['forDay']
            ));
    }
}
