<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slack extends Model
{
    const ACTIONS = [
        'weather_notification',
        'gpu_problem_notification',
        'crashed_channel',
        'calendar_notification',
        'restart_channel'
    ];
    protected $fillable = [
        'url', 'description', 'action'
    ];
}
