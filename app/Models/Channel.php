<?php

namespace App\Models;

use App\Observers\ChannelObserver;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy(ChannelObserver::class)]
class Channel extends Model
{
    const QUALITIES = [
        [
            'id' => 1,
            'name' => 'UHD',
        ],
        [
            'id' => 2,
            'name' => 'FullHD',
        ],
        [
            'id' => 3,
            'name' => 'HD',
        ],
        [
            'id' => 4,
            'name' => 'SD',
        ],
    ];

    protected $fillable = [
        'name',
        'logo',
        'is_radio',
        'is_multiscreen',
        'quality',
        'category',
        'description',
        'nangu_chunk_store_id',
        'nangu_channel_code',
        'geniustv_channel_packages_id',
        'epg_id',
        'channel_region_id',
        'channel_programmer_id'
    ];

    protected $casts = [
        'is_radio' => 'boolean',
        'is_multiscreen' => 'boolean',
    ];

    // protected function geniustv_channel_packages_id(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => json_decode($value, true),
    //         set: fn ($value) => json_encode($value)
    //     );
    // }

    public function channelCategory(): HasOne
    {
        return $this->hasOne(ChannelCategory::class, 'id', 'category');
    }

    public function multicasts(): HasMany
    {
        return $this->hasMany(ChannelMulticast::class, 'channel_id');
    }

    public function h264(): HasOne
    {
        return $this->hasOne(H264::class, 'channel_id');
    }

    public function h265(): HasOne
    {
        return $this->hasOne(H265::class, 'channel_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'channel_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(ChannelRegion::class, 'channel_region_id', 'id');
    }

    public function channelProgramer(): BelongsTo
    {
        return $this->belongsTo(ChannelProgramer::class, 'channel_programmer_id', 'id');
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('name', 'like', '%' . $search . '%');
    }

    public static function scopeSearchend(Builder $query, string $search): void
    {
        $query->where('name', 'like', $search . '%');
    }

    public function scopeFulltextSearch(Builder $query, string $search): void
    {
        $query->whereFullText(
            ['name', 'description', 'nangu_channel_code'],
            "$search*",
            ['mode' => 'boolean'],
        );
    }

    public function scopeWithNanguChannelCode(Builder $query): void
    {
        $query->where('nangu_channel_code', '!=', null);
    }
}
