<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChannelProgramerChannel extends Model
{
    protected $fillable = [
        'channel_id',
        'channel_programmer_id'
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function channelProgrammer(): BelongsTo
    {
        return $this->belongsTo(ChannelProgramer::class, 'channel_programmer_id');
    }
}
