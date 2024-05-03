<?php

namespace App\Exports;

use App\Models\H265;
use Maatwebsite\Excel\Concerns\FromCollection;

class H265sExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return H265::all();
    }
}
