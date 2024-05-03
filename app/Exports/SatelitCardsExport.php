<?php

namespace App\Exports;

use App\Models\SatelitCard;
use Maatwebsite\Excel\Concerns\FromCollection;

class SatelitCardsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SatelitCard::all();
    }
}
