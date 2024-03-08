<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceVendorSnmp extends Model
{
    protected $fillable = [
        'device_vendor_id',
        'oid',
        'description',
        'human_description',
        'type',
        'interface',
        'interface_number',
        'can_chart',
    ];
}
