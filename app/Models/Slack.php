<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class Slack extends Model
{
    const ACTIONS = [
        'weather_notification',
        'gpu_problem_notification',
        'crashed_channel',
        'calendar_notification',
        'restart_channel',
        'satelit_cards_expiration'
    ];

    protected $fillable = [
        'url', 'description', 'action',
    ];

    public function scopeRestartChannelAction(Builder $query)
    {
        return $query->where('action', 'restart_channel');
    }

    public function scopeCrashedChannelAction(Builder $query)
    {
        return $query->where('action', 'crashed_channel');
    }

    public function scopeWeatherNotificationAction(Builder $query)
    {
        return $query->where('action', 'weather_notification');
    }

    public function scopeGpuProblemNotificationAction(Builder $query)
    {
        return $query->where('action', 'gpu_problem_notification');
    }

    public function scopeSatelitcardExpiration(Builder $query)
    {
        return $query->where('action', 'satelit_cards_expiration');
    }

    public function scopeSearch(Builder $query, string $search = '')
    {
        return $query->where('description', 'like', '%'.$search.'%')->orWhere('url', 'like', '%'.$search.'%');
    }
}
