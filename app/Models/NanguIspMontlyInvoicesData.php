<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NanguIspMontlyInvoicesData extends Model
{
    protected $fillable = [
        'nangu_isp_id',
        'invoice_data',
        'price'
    ];

    public function nanguIsp(): BelongsTo
    {
        return $this->belongsTo(NanguIsp::class, 'nangu_isp_id', 'id');
    }
}
