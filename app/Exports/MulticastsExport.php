<?php

namespace App\Exports;

use App\Models\ChannelMulticast;
use Maatwebsite\Excel\Concerns\FromCollection;

class MulticastsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ChannelMulticast::all();
    }
}
