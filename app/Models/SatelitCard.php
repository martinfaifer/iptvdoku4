<?php

namespace App\Models;

use App\Observers\SatelitCardObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(SatelitCardObserver::class)]
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