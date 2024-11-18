<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class HboUsageExport implements FromView
{

    public function __construct(public array $usage) {}

    public function view(): View
    {
        return view('exports.hbo-usage', [
            'usage' => $this->usage
        ]);
    }
}
