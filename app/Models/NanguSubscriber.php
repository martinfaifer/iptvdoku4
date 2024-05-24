<?php

namespace App\Models;

use App\Traits\Models\NanguIspTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NanguSubscriber extends Model
{
    use NanguIspTrait;

    protected $fillable = [
        'subscriberCode',
        'nangu_isp_id',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(NanguSubscription::class, 'nangu_subscriber_id', 'id');
    }
}
