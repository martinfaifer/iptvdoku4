<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SatelitCard extends Model
{
    protected $fillable = [
        'name',
        'satelit_card_vendor_id',
        'status',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(SatelitCardVendor::class, 'satelit_card_vendor_id');
    }
}
