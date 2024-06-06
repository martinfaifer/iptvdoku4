<?php

namespace App\Observers;

use App\Models\Ip;
use Illuminate\Support\Facades\Cache;

class IpObserver
{
    public function created(Ip $ip)
    {
        Cache::pull('nangu_ip_prefixes_menu');
    }

    public function updated(Ip $ip)
    {
        Cache::pull('nangu_ip_prefixes_menu');
    }

    public function deleted(Ip $ip)
    {
        Cache::pull('nangu_ip_prefixes_menu');
    }
}
