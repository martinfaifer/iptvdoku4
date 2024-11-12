<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChannelProgramerContanct extends Model
{
    protected $fillable = [
        'channel_programmer_id', 'name', 'email', 'phone'
    ];

    public function channelProgrammer(): BelongsTo
    {
        return $this->belongsTo(ChannelProgramer::class, 'channel_programmer_id');
    }
}
