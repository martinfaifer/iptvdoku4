<?php

namespace App\Http\Resources;

use App\Models\ChannelMulticast;
use App\Models\ChannelQualityWithIp;
use App\Traits\Channels\GetGeniusTvChannelPaclagesTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiChannelResource extends JsonResource
{
    use GetGeniusTvChannelPaclagesTrait;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $request->channel_url
        if (ChannelMulticast::where('stb_ip', $request->channel_url)->first()) {
            $channel = ChannelMulticast::where('stb_ip', $request->channel_url)
                ->with('channel', 'channel_source', 'notes')
                ->first();

            return $this->setOutput($channel);
        }

        if (ChannelQualityWithIp::where('ip', $request->channel_url)->first()) {
            $channel = ChannelQualityWithIp::where('ip', $request->channel_url)
                ->with('h264.channel', 'h265.channel')
                ->first();

            if (! is_null($channel->h264_id)) {
                return $this->setUnicastOutput($channel, 'h264');
            }

            if (! is_null($channel->h265_id)) {
                return $this->setUnicastOutput($channel, 'h265');
            }
        }

        return abort(404);
    }

    public function setOutput(object $channel): array
    {
        return [
            'logo' => is_null($channel->channel->logo) ? null : config('app.url').'/'.str_replace('public', 'storage', $channel->channel->logo),
            'kategorie' => $channel->channel->channelCategory->name,
            'chunkStoreId' => null,
            'nanguChannel' => null,
            'tags' => null,
            'channel_packages' => implode($this->get_packages(json_decode($channel->channel->geniustv_channel_packages_id))),
            'devices' => [
                'source' => [
                    'url' => null,
                    'name' => null,
                    'ip' => null,
                    'status' => null,
                    'template' => null,
                    'deviceVendor' => null,
                    'category' => null,
                ],
                'multiplexor' => [
                    'url' => null,
                    'name' => null,
                    'ip' => null,
                    'status' => null,
                    'template' => null,
                    'deviceVendor' => null,
                    'category' => null,
                ],
            ],
            'notes' => $channel->notes->take(2),
        ];
    }

    public function setUnicastOutput(object $channel, string $type): array
    {
        return [
            'logo' => is_null($channel->$type->channel->logo) ? null : config('app.url').'/'.str_replace('public', 'storage', $channel->$type->channel->logo),
            'kategorie' => $channel->$type->channel->channelCategory->name,
            'chunkStoreId' => null,
            'nanguChannel' => null,
            'tags' => null,
            'channel_packages' => implode($this->get_packages(json_decode($channel->$type->channel->geniustv_channel_packages_id))),
            'devices' => [
                'source' => [
                    'url' => null,
                    'name' => null,
                    'ip' => null,
                    'status' => null,
                    'template' => null,
                    'deviceVendor' => null,
                    'category' => null,
                ],
                'multiplexor' => [
                    'url' => null,
                    'name' => null,
                    'ip' => null,
                    'status' => null,
                    'template' => null,
                    'deviceVendor' => null,
                    'category' => null,
                ],
            ],
            'notes' => $channel->$type->notes->take(2),
        ];
    }
}
