<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\H265;
use App\Models\Channel;
use Livewire\Attributes\Validate;
use App\Models\ChannelQualityWithIp;

class StoreH265ChannelForm extends Form
{
    public ?Channel $channel;

    public $ips = [];

    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    public function store(): bool
    {
        if (empty($this->ips)) {
            return false;
        }
        // store h264
        $h265 = H265::where('channel_id', $this->channel->id)->first();
        if (!$h265) {
            $h265 = H265::create([
                'channel_id' => $this->channel->id
            ]);
        }

        foreach ($this->ips as $qualityId => $ip) {
            ChannelQualityWithIp::create([
                'h265_id' => $h265->id,
                'channel_quality_id' => $qualityId,
                'ip' => $ip
            ]);
        }

        return true;
    }
}
