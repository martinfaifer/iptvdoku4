<?php

namespace App\Exports;

use App\Models\H264;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class H264sExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'název',
            'IP',
        ];
    }

    public function array(): array
    {
        $result = [];
        $ips = [];
        $h264s = H264::with(['channel', 'ips'])->get();
        foreach ($h264s as $h264) {
            foreach ($h264->ips as $ip) {
                $ips[] = $ip->ip;
            }

            $result[] = [
                'name' => $h264->channel->name,
                'ip' => implode(',', $ips),
            ];

            $ips = [];
        }

        return $result;
    }
}
