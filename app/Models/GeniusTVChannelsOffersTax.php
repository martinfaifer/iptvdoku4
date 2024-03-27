<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeniusTVChannelsOffersTax extends Model
{
    protected $fillable = [
        'offer',
        'channels_id',
        'price',
        'currency'
    ];

    public function currency_name(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency', 'id');
    }
}
