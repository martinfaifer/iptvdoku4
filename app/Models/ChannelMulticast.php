<?php

namespace App\Models;

use App\Observers\MulticastChannelObserver;
use App\Traits\Models\ChannelTrait;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

    public function channel_source(): HasOne
    {
        return $this->hasOne(ChannelSource::class, 'id', 'channel_source_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'channel_id', 'id');
    }

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->where('stb_ip', 'like', '%' . $search . '%')->orWhere('source_ip', 'like', '%' . $search . '%');
    }

    public function scopeFulltextSearch(Builder $query, string $search)
    {
        return $query->whereFullText(
            ['stb_ip', 'source_ip'],
            "$search*",
            ['mode' => 'boolean'],
        );
    }
}
