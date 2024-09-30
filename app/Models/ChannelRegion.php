<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChannelRegion extends Model
{
    protected $fillable = [
        'name',
    ];

    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class, 'channel_region_id');
    }
}
