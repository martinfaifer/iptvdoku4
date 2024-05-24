<?php
namespace App\Traits\Models;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait ChannelTrait
{
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
}
