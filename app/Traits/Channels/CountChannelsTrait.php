<?php

namespace App\Traits\Channels;

use App\Models\Channel;
use App\Models\ChannelMulticast;
use App\Models\H264;
use App\Models\H265;

trait CountChannelsTrait
{
    public function count_channels(): int
    {
        return Channel::count();
    }

    public function count_multicasts(): int
    {
        return ChannelMulticast::count();
    }

    public function count_h264s(): int
    {
        return H264::count();
    }

    public function count_h265s(): int
    {
        return H265::count();
    }
}
