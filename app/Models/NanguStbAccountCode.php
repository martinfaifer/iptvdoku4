<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NanguStbAccountCode extends Model
{
    protected $fillable = [
        'nangu_subscription_code_id',
        'stbAccountCodes',
    ];

    public function subscriptionCode(): BelongsTo
    {
        return $this->belongsTo(NanguSubscription::class, 'nangu_subscription_code_id', 'id');
    }
}
