<?php

namespace App\Exports;

use App\Models\Channel;
use App\Models\GeniusTvChart;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ChannelsUsagePerIspExport implements FromArray, WithHeadings
{
    public function __construct(public $nanguIsp)
    {
        //
    }

    public function headings(): array
    {
        return [
            'kanál',
            'tento měsíc',
            'minulý měsíc',
            'průměr'
        ];
    }

    public function array(): array
    {
        $channels = Channel::withNanguChannelCode()->get(['id', 'name']);
        $csvData = [];

        foreach ($channels as $channel) {
            $thisMonthUsage = 0;
            $lastMonthUsage = 0;
            $svg = 0;

            $channelUsage = GeniusTvChart::lastMonthAndNew()->isChannel($channel->id)->forNanguIsp($this->nanguIsp->id)->get();
            foreach ($channelUsage as $channelUsageData) {
                if ($channelUsageData->created_at->format('m') == now()->format('m')) {
                    $thisMonthUsage = $channelUsageData->value;
                } else {
                    $lastMonthUsage = $channelUsageData->value;
                }
            }
            $csvData[] = [
                'name' => $channel->name,
                'last_month' => $lastMonthUsage,
                'this_month' => $thisMonthUsage,
                'avg' => ($thisMonthUsage + $lastMonthUsage) / 2,
            ];
        }

        return $csvData;
    }
}
