<?php

namespace App\Exports;

use App\Models\ChannelMulticast;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class MulticastsExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'název',
            'STB IP',
            'Zdrojová IP'
        ];
    }

    public function array(): array
    {
        $result = [];
        $multicasts = ChannelMulticast::with('channel')->get();
        foreach ($multicasts as $multicast) {
            $result[] = [
                'name' => $multicast->channel->name,
                'stb_ip' => $multicast->stb_ip,
               'source_ip' => $multicast->source_ip,
            ];
        }

        return $result;
    }
}
