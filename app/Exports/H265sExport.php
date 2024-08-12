<?php

namespace App\Exports;

use App\Models\H265;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class H265sExport implements FromArray, WithHeadings
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
        $h265s = H265::with(['channel', 'ips'])->get();
        foreach ($h265s as $h265) {
            foreach ($h265->ips as $ip) {
                $ips[] = $ip->ip;
            }

            $result[] = [
                'name' => $h265->channel->name,
                'ip' => implode(",", $ips),
            ];

            $ips = [];
        }

        return $result;
    }
}
