<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceVendor extends Model
{
    protected $fillable = [
        'name'
    ];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'device_vendor_id', 'id');
    }

    public function hasSnmp(): HasMany
    {
        return $this->hasMany(DeviceVendorSnmp::class, 'device_vendor_id');
    }
}
