<?php

namespace App\Actions\Channels;

use App\Models\Note;
use App\Models\Channel;
use App\Models\Contact;
use App\Models\RestartChannel;
use App\Models\ChannelMulticast;
use App\Models\ChannelQualityWithIp;
use App\Actions\Devices\RemoveChannelFromDeviceAction;

class CompletlyDeleteChannelAction
{
    public function __construct(public object $channel)
    {
        //
    }

    public function __invoke(): void
    {
        // delete form restart channel table
        RestartChannel::where('channel_id', $this->channel->id)->delete();
        // delete h264 & h265
        if (!blank($this->channel->h264)) {
            ChannelQualityWithIp::where('h264_id', $this->channel->h264->id)->delete();
            // $this->channel->h264->ips->delete();
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

        if (!blank($this->channel->h265)) {
            ChannelQualityWithIp::where('h265_id', $this->channel->h265->id)->delete();
            // $this->channel->h265->ips->delete();
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

        if (!$this->channel->multicasts->isEmpty()) {
            ChannelMulticast::where('channel_id', $this->channel->id)->delete();
            // $this->channel->multicasts->delete();
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
        if (!$this->channel->notes->isEmpty()) {
            Note::where('channel_id', $this->channel->id)->delete();
        }

        // delete channel contacts
        Contact::where('type', 'channel')->where('item_id', $this->channel->id)->delete();

        $this->channel->delete();
    }
}
