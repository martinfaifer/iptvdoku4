<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'channels',
        'nangu_isp_id',
    ];

    public function nanguIsp(): BelongsTo
    {
        return $this->belongsTo(NanguIsp::class, 'nangu_isp_id', 'id');
    }

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(NanguSubscriber::class, 'nangu_subscriber_id', 'id');
    }

    public function accountCodes(): HasMany
    {
        return $this->hasMany(NanguStbAccountCode::class, 'nangu_subscription_code_id', 'id');
    }

    public function scopeIsBilling(Builder $query)
    {
        return $query->where('subscriptionState', 'BILLING');
    }

    public function scopeForIsp(Builder $query, string|int $nanguIspId)
    {
        return $query->where('nangu_isp_id', $nanguIspId);
    }

    public function scopeHasChannel(Builder $query, string $channel)
    {
        return $query->where('channels', 'like', '%'.$channel.'%');
    }

    public function scopeUniqueTariffCodes(Builder $query)
    {
        return $query->distinct()->get('tariffCode');
    }

    public function scopeTarrifCode(Builder $query, string $tarrifCode)
    {
        return $query->where('tariffCode', $tarrifCode);
    }

    public function scopeOfferCode(Builder $query, string $offerCode)
    {
        return $query->where('offers', 'like', '%'.$offerCode.'%');
    }
}
