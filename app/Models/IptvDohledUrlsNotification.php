<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IptvDohledUrlsNotification extends Model
{
    protected $fillable = [
        'iptv_dohled_url_id',
        'email',
        'slack_channel'
    ];
}
