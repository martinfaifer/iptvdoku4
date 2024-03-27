<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NanguSubscription extends Model
{
    protected $fillable = [
        'nangu_subscriber_id',
        'subscriptionCode',
        'subscriptionState',
        'tariffCode',
        'localityCode',
        'channelPackagesCodes',
        'offers',
        'channels'
    ];

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(NanguSubscriber::class, 'nangu_subscriber_id', 'id');
    }
}
