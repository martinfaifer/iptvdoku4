<?php

namespace App\Actions\Channels;

use App\Actions\Devices\RemoveChannelFromDeviceAction;
use App\Models\Channel;
use App\Models\ChannelMulticast;
use App\Models\ChannelQualityWithIp;
use App\Models\Note;
use App\Models\RestartChannel;

class CompletlyDeleteChannelAction
{
    public function __construct(public Channel $channel)
    {
        //
    }

    public function __invoke(): bool
    {
        // delete form restart channel table
        RestartChannel::where('channel_id', $this->channel->id)->delete();
        // try {
            // delete h264 & h265
            if (! is_null($this->channel->h264)) {
                ChannelQualityWithIp::where('h264_id', $this->channel->h264->id)->delete();
                $this->channel->h264->delete();
                // dispatch delete channel from device
                (new RemoveChannelFromDeviceAction(
                    'h264',
                    $this->channel->id,
                    false
                ))();
                (new RemoveChannelFromDeviceAction(
                    'h264',
                    $this->channel->id,
                    true
                ))();
            }

            if (! is_null($this->channel->h265)) {
                ChannelQualityWithIp::where('h265_id', $this->channel->h265->id)->delete();
                $this->channel->h265->delete();
                // dispatch delete channel from device
                (new RemoveChannelFromDeviceAction(
                    'h265',
                    $this->channel->id,
                    false
                ))();
                (new RemoveChannelFromDeviceAction(
                    'h265',
                    $this->channel->id,
                    true
                ))();

            }

            if (! $this->channel->multicasts->isEmpty()) {
                ChannelMulticast::where('channel_id', $this->channel->id)->delete();
                // dispatch delete channel from device
                (new RemoveChannelFromDeviceAction(
                    'multicast',
                    $this->channel->id,
                    false
                ))();
                (new RemoveChannelFromDeviceAction(
                    'multicast',
                    $this->channel->id,
                    true
                ))();
            }

            Note::where('channel_id', $this->channel->id)->delete();

            $this->channel->delete();

            return true;
        // } catch (\Throwable $th) {
        //     return false;
        // }
    }
}
