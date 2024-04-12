<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NanguSubscriber extends Model
{
    protected $fillable = [
        'subscriberCode',
        'nangu_isp_id'
    ];

    public function nanguIsp(): BelongsTo
    {
        return $this->belongsTo(NanguIsp::class, 'nangu_isp_id', 'id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(NanguSubscription::class, 'nangu_subscriber_id', 'id');
    }
}
