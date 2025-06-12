<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IptvPromo extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'locality',
        'phone',
        'email',
        'creator', // User email
        'expiration', // format dd.mm. yyyy
        'subscriberCode',
        'ispCode',
        'subscriptionCode',
        'subscriptionStbAccountCode',
        // 'stb_serialNumber',
        // 'stb_macAddress',
        // 'pairingPin',
        'username',
        'password',
        'identityId',
        'expired' // boolean
    ];


    protected $casts = [
        'expired' => 'boolean'
    ];
}
