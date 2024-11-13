<?php

namespace App\Traits\Programmers;

use App\Models\NanguIsp;
use App\Models\ChannelProgramer;
use App\Models\NanguSubscription;
use Illuminate\Support\Facades\Cache;

trait CountProgrammersUsageTrait
{
    public function count_programmers_usage()
    {
        $result = [];
        $programmers = ChannelProgramer::with('channels')->get();
        $isps = NanguIsp::get();
        foreach ($programmers as $programmer) {
            if (!blank($programmer->channels)) {
                foreach ($programmer->channels as $channel) {
                    $result[$programmer->name][$channel->name]['celkem'] = NanguSubscription::where('channels', "like", "%" . $channel->nangu_channel_code . "%")->count();
                    foreach ($isps as $isp) {
                        $result[$programmer->name][$channel->name][$isp->name] = NanguSubscription::where('nangu_isp_id', $isp->id)->where('channels', "like", "%" . $channel->nangu_channel_code . "%")->count();
                    }
                }
            }
        }

        Cache::forever('programmers_usage', $result);
    }
}
