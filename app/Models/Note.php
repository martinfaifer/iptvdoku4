<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    protected $fillable = [
        'channel_id',
        'h264_id',
        'h265_id',
        'device_id',
        'satelit_card_id',
        'note',
        'user',
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function h264(): BelongsTo
    {
        return $this->belongsTo(H264::class, 'h264_id');
    }

    public function h265(): BelongsTo
    {
        return $this->belongsTo(H265::class, 'h265_id');
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function satelit_card(): BelongsTo
    {
        return $this->belongsTo(SatelitCard::class, 'satelit_card_id', 'id');
    }
}
