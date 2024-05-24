<?php

namespace App\Models;

use App\Traits\Models\ChannelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Observers\MulticastChannelObserver;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(MulticastChannelObserver::class)]
class ChannelMulticast extends Model
{
    use ChannelTrait;

    protected $fillable = [
        'channel_id',
        'stb_ip',
        'source_ip',
        'channel_source_id',
        'is_backup',
        'devices_id',
        'status',
    ];

    public function multicasts(): HasMany
    {
        return $this->hasMany(ChannelMulticast::class, 'channel_id', 'id');
    }

    public function channel_source(): HasOne
    {
        return $this->hasOne(ChannelSource::class, 'id', 'channel_source_id');
    }

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->where('stb_ip', 'like', '%'.$search.'%')->orWhere('source_ip', 'like', '%'.$search.'%');
    }
}
