<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DevicesExport implements FromArray, WithHeadings
{

    public function headings(): array
    {
        return [
            'název',
            'ip',
            'controller ip',
            'IPMI',
            'username',
            'password',
        ];
    }


    public function array(): array
    {
        return Device::get(['name', 'ip', 'controller_ip', 'ipmi_ip', 'username', 'password'])->toArray();
    }
}
