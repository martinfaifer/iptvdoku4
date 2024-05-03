<?php

namespace App\Exports;

use App\Models\H264;
use Maatwebsite\Excel\Concerns\FromCollection;

class H264sExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return H264::all();
    }
}
