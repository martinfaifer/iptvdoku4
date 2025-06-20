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
        'satelit_cards_expiration',
        'device_error',
    ];

    protected $fillable = [
        'url',
        'description',
        'action',
    ];

    public function scopeRestartChannelAction(Builder $query): void
    {
        $query->where('action', 'restart_channel');
    }

    public function scopeCrashedChannelAction(Builder $query): void
    {
        $query->where('action', 'crashed_channel');
    }

    public function scopeWeatherNotificationAction(Builder $query): void
    {
        $query->where('action', 'weather_notification');
    }

    public function scopeGpuProblemNotificationAction(Builder $query): void
    {
        $query->where('action', 'gpu_problem_notification');
    }
    public function scopeCpuHighUsageAction(Builder $query): void
    {
        $query->where('action', 'cpu_high_usage');
    }

    public function scopeSatelitcardExpiration(Builder $query): void
    {
        $query->where('action', 'satelit_cards_expiration');
    }

    public function scopeDeviceError(Builder $query): void
    {
        $query->where('action', 'device_error');
    }

    public function scopeSearch(Builder $query, string $search = ''): void
    {
        $query->where('description', 'like', '%' . $search . '%')->orWhere('url', 'like', '%' . $search . '%');
    }
}
