<?php

namespace App\Models;

use App\Traits\Models\NanguIspTrait;
use Illuminate\Database\Eloquent\Model;

class NanguIspMontlyInvoicesData extends Model
{
    use NanguIspTrait;

    protected $fillable = [
        'nangu_isp_id',
        'invoice_data',
        'price',
    ];
}
