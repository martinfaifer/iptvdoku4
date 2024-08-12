<?php

namespace App\Exports;

use App\Models\Channel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ChannelsExport implements FromCollection, WithHeadings
{

    public function headings(): array
    {
        return [
            'název',
            'kvalita',
            'popis'
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Channel::with('channelCategory')->get(['name', 'quality', 'description']);
    }
}
