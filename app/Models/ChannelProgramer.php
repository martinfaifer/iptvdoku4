<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChannelProgramer extends Model
{
    protected $fillable = [
        'name'
    ];

    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class, 'channel_programmer_id', 'id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(ChannelProgramerContanct::class, 'channel_programmer_id', 'id');
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('name', 'like', $search . '%');
    }
}
