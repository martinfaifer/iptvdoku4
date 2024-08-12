<?php

namespace App\Exports;

use App\Models\SatelitCard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SatelitCardsExport implements FromCollection, WithHeadings
{

    public function headings(): array
    {
        return [
            'cislo',
            'status',
            'expirace',
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SatelitCard::get(['name','status', 'expiration']);
    }
}
