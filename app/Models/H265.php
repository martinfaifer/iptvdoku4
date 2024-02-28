<?php

namespace App\Models;

use App\Observers\H265Observer;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(H265Observer::class)]
class H265 extends Model
{
    protected $fillable = [
        'channel_id',
        'devices_id',
        'status'
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function ips(): HasMany
    {
        return $this->hasMany(ChannelQualityWithIp::class, 'h265_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'h265_id');
    }
}
