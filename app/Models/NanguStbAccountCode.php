<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function stbs(): HasOne
    {
        return $this->hasOne(NanguStb::class, 'nangu_stb_accountCode_id', 'id');
    }
}
