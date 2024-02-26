<?php
namespace App\Traits\Channels;

use App\Models\ChannelMulticast;
use App\Models\H264;
use App\Models\H265;

trait GetChannelBelongsToDeviceTrait
{
    public function channel(string $channelType = 'multicast', int $channel_id, bool $isBackup):null|array
    {
        if($channelType == 'multicast') {
            $channel = ChannelMulticast::where('channel_id', $channel_id)->first();
        }

        if($channelType == 'h264') {
            $channel = H264::where('channel_id', $channel_id)->first();
        }

        if($channelType == 'h265') {
            $channel = H265::where('channel_id', $channel_id)->first();
        }

        if(!isset($channel)) {
            return null;
        }

        return [
            'id' => $channel_id,
            'channelType' => $channelType,
            'name' => $channel->channel->name,
            'isBackup' => $isBackup
        ];
    }
}
