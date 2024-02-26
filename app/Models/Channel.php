<?php

namespace App\Models;

use App\Observers\ChannelObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(ChannelObserver::class)]
class Channel extends Model
{
    const QUALITIES = [
        [
            'id' => 1,
            'name' => "UHD"
        ],
        [
            'id' => 2,
            'name' => "FullHD"
        ],
        [
            'id' => 3,
            'name' => "HD"
        ],
        [
            'id' => 4,
            'name' => "SD"
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
        'nangu_channel_code'
    ];

    protected $casts = [
        'is_radio' => 'boolean',
        'is_multiscreen' => 'boolean',
    ];

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
}
