<?php

namespace App\Traits\Channels;

use App\Models\Channel;
use App\Models\ChannelMulticast;

trait GetAllChannelStreamsTrait
{
    public function getStreams(Channel $channel): array
    {
        $streams = [];

        array_push($streams, ...$this->getMulticastsStreams($channel));
        array_push($streams, ...$this->getH264Streams($channel));
        array_push($streams, ...$this->getH265Streams($channel));

        return $streams;
    }

    public function getMulticastsStreams(Channel $channel): array
    {
        $streams = [];
        foreach ($channel->multicasts as $multicast) {
            if (!blank($multicast->stb_ip)) {
                array_push($streams, $multicast->stb_ip);
            }

            if (!blank($multicast->source_ip)) {
                array_push($streams, $multicast->source_ip);
            }
        }

        return $streams;
    }

    public function getH264Streams(Channel $channel): array
    {
        $streams = [];
        if (blank($channel->h264)) {
            return $streams;
        }

        foreach ($channel->h264->ips as $quality) {
            array_push($streams, $quality->ip);
        }

        return $streams;
    }

    public function getH265Streams(Channel $channel): array
    {
        $streams = [];
        if (blank($channel->h265)) {
            return $streams;
        }

        foreach ($channel->h265->ips as $quality) {
            array_push($streams, $quality->ip);
        }

        return $streams;
    }
}
