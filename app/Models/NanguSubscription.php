<?php

namespace App\Models;

use App\Traits\Models\NanguIspTrait;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NanguSubscription extends Model
{
    use NanguIspTrait;

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

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(NanguSubscriber::class, 'nangu_subscriber_id', 'id');
    }

    public function accountCodes(): HasMany
    {
        return $this->hasMany(NanguStbAccountCode::class, 'nangu_subscription_code_id', 'id');
    }

    public function scopeIsBilling(Builder $query): void
    {
        $query->where('subscriptionState', 'BILLING');
    }

    public function scopeIsNew(Builder $query): void
    {
        $query->where('subscriptionState', 'NEW');
    }

    public function scopeForIsp(Builder $query, string|int $nanguIspId): void
    {
        $query->where('nangu_isp_id', $nanguIspId);
    }

    public function scopeHasChannel(Builder $query, string $channel = ''): void
    {
        $query->where('channels', 'like', '%' . $channel . '%');
    }

    // public function scopeUniqueTariffCodes(Builder $query): void
    // {
    //     $query->distinct()->get('tariffCode');
    // }

    public function scopeTarrifCode(Builder $query, string $tarrifCode): void
    {
        $query->where('tariffCode', $tarrifCode);
    }

    public function scopeOfferCode(Builder $query, string $offerCode): void
    {
        $query->where('offers', 'like', '%' . $offerCode . '%');
    }
}
