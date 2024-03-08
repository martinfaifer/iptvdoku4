<?php

namespace App\Actions\Devices;

use App\Models\Tag;
use App\Models\Device;
use App\Models\TagOnItem;
use Illuminate\Support\Facades\Cache;
use App\Services\Api\Nimble\ConnectService;

class GetNimbleDataAction
{
    public function __construct()
    {
    }

    public function __invoke()
    {
        $nimbleServers = (new ConnectService())->connect();

        if ($nimbleServers == false) {
            exit('nimble servers problem');
        }

        foreach ($nimbleServers['servers'] as $nimbleServer) {
            $device = Device::where('ip', $nimbleServer['ip'][0])->first();
            if ($device) {
                Cache::put('nimble_' . $device->id, [
                    'device' => $device->id,
                    'nimble_id' => $nimbleServer['id']
                ], 3600);
            }
        }


        Tag::where('action', 3)->get()->each(function ($tag) {
            // search if tag has bound to device
            TagOnItem::where('type', 'device')->where('tag_id', $tag->id)->get()->each(function ($tagOnItem) {
                $device = Device::find($tagOnItem->item_id);

                if ($cachedNimbleKey = Cache::get('nimble_' . $device->id)) {
                    $incomingStreams = (new ConnectService())->connect(
                        endpoint: "incoming_streams",
                        serverId: $cachedNimbleKey['nimble_id']
                    );

                    Cache::put('nimble_' . $device->id . "_incoming_streams", $incomingStreams['streams'], 3600);

                    $outgoingStreams = (new ConnectService())->connect(
                        endpoint: "outgoing_streams",
                        serverId: $cachedNimbleKey['nimble_id']
                    );

                    Cache::put('nimble_' . $device->id . "_outgoing_streams", $outgoingStreams['streams'], 3600);
                }
            });
        });
    }
}
