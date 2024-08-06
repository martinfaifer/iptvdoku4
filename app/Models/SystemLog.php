<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    const FATAL_ERROR = 'fatal';
    const WARNING_ERROR = 'warning';

    protected $fillable = [
        'type', // fatal, warning
        'action', // can be Action, Service ...
        'payload'
    ];
}
