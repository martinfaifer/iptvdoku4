<?php

namespace App\Models;

use App\Traits\Models\NanguIspTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NanguIspMontlyInvoicesData extends Model
{
    use NanguIspTrait;

    protected $fillable = [
        'nangu_isp_id',
        'invoice_data',
        'price',
    ];
}
