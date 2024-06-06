<?php

namespace App\Exports;

use App\Models\Channel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ChannelsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Channel::with('channelCategory')->get();
    }
}
