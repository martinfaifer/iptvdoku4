<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;

class Slack extends Model
{
    const ACTIONS = [
        'weather_notification',
        'gpu_problem_notification',
        'crashed_channel',
        'calendar_notification',
        'restart_channel',
    ];
    protected $fillable = [
        'url', 'description', 'action'
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

    public function scopeSearch(Builder $query, string $search = "")
    {
        return $query->where('description', "%" . $search . "%")->orWhere('url', "like", "%" . $search . "%");
    }
}
