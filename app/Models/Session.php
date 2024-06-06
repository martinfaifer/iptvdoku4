<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';

    protected $casts = [
        'last_activity' => 'datetime',
    ];

    public function scopeForUser(Builder $query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
