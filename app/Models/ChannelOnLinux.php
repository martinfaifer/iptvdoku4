<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelOnLinux extends Model
{
    protected $fillable = [
        'channel_type', // multicast, h264, h265
        'channel_id',
        'device_id',
        'path',
    ];
}
